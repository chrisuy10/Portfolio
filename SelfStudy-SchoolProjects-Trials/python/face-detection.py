import cv2
import os

def recognize_faces():
    print("Initializing webcam...")

    # Load the Haar Cascade XML file for face detection
    cascade_path = 'C:\\Users\\AyarFarhan\\Downloads\\haarcascade_frontalcatface.xml'
    face_cascade = cv2.CascadeClassifier(cascade_path)

    # Initialize the video capture
    cap = cv2.VideoCapture(0)
    print("Webcam initialized.")

    # Load the registered face images and corresponding names
    registered_faces = []
    registered_names = []
    for filename in os.listdir('registered_faces'):
        if filename.endswith('.jpg'):
            face_image = cv2.imread(os.path.join('registered_faces', filename), cv2.IMREAD_GRAYSCALE)  # Load as grayscale
            registered_faces.append(face_image)
            registered_names.append(filename.split('_')[0])  # Assuming the format is "name_ID.jpg"

    recognized_name = "Unknown"

    while True:
        # Capture frame-by-frame
        ret, frame = cap.read()

        if not ret:
            break

        # Convert the frame to grayscale for face detection
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

        # Detect faces in the frame
        faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

        for (x, y, w, h) in faces:
            # Extract the detected face region
            face_roi = gray[y:y+h, x:x+w]
            face_roi_resized = cv2.resize(face_roi, (registered_faces[0].shape[1], registered_faces[0].shape[0]))

            best_similarity = float('inf')  # Initialize with a high value
            recognized_name = "Unknown"

            # Compare the resized detected face with registered faces
            for i, registered_face_gray in enumerate(registered_faces):
                # Resize the registered face image to match the size of the detected face region
                registered_face_resized = cv2.resize(registered_face_gray, (registered_faces[0].shape[1], registered_faces[0].shape[0]))

                # Calculate similarity using absolute difference
                diff = cv2.absdiff(registered_face_resized, face_roi_resized)
                similarity = cv2.countNonZero(diff)

                if similarity < best_similarity:
                    best_similarity = similarity
                    recognized_name = registered_names[i]

            # Draw a rectangle around the detected face
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 3)
            label = f"{recognized_name} ({100 - (best_similarity / (w * h)):.2f}%)"
            cv2.putText(frame, label, (x, y - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

        # Display the frame
        cv2.imshow('Recognize Face', frame)

        # Break the loop if 'q' is pressed
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

    # Release the video capture and close the OpenCV window
    cap.release()
    cv2.destroyAllWindows()
    print("Webcam released. Recognition finished.")

if __name__ == "__main__":
    recognize_faces()
