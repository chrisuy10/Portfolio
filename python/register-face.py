import cv2
import os
import threading
import keyboard
import time

# Initialize the webcam, Haar Cascade XML file, and video capture
print("Initializing webcam...")

cascade_path = 'C:\\Users\\AyarFarhan\\Downloads\\haarcascade_frontalcatface.xml'
face_cascade = cv2.CascadeClassifier(cascade_path)

cap = cv2.VideoCapture(0)
print("Webcam initialized.")

def handle_key_events():
    print("Press 's' to save multiple face images, 'q' to quit.")
    while True:
        if keyboard.is_pressed('s'):
            print("Saving...")
            save_multiple_images(name, 30, 5)  # Save 30 images within 5 seconds
            keyboard.wait('s')  # Wait for the key to be released
        elif keyboard.is_pressed('q'):
            event.set()  # Signal the main loop to quit
            break

def save_multiple_images(label, num_images, time_limit):
    start_time = time.time()
    image_count = 0

    while image_count < num_images and time.time() - start_time < time_limit:
        # Capture frame-by-frame
        ret, frame = cap.read()

        if not ret:
            break

        # Convert the frame to grayscale for face detection
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

        # Detect faces in the frame
        faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

        for (x, y, w, h) in faces:
            # Capture the face image and save it
            face_image = gray[y:y+h, x:x+w]
            face_id = len(os.listdir('registered_faces')) + 1
            cv2.imwrite(f'registered_faces/{label}_{face_id}.jpg', face_image)
            image_count += 1

            if image_count >= num_images:
                print(f"Saved {num_images} images for {label}.")
                return

    print(f"Saved {image_count} images for {label}.")

def register_face(name):
    # Create a directory to store registered faces
    if not os.path.exists('registered_faces'):
        os.makedirs('registered_faces')

    # Start the key event handling thread
    key_thread = threading.Thread(target=handle_key_events)
    key_thread.daemon = True  # Set the thread to be a daemon
    key_thread.start()

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
            # Draw a rectangle around the detected face
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 3)
            event.wait()  # Wait for the event to be set
            event.clear()  # Clear the event for the next iteration
            
            # Capture the face image and save it
            face_image = gray[y:y+h, x:x+w]
            face_id = len(os.listdir('registered_faces')) + 1
            cv2.imwrite(f'registered_faces/{name}_{face_id}.jpg', face_image)
            print(f"Saved {name}_{face_id}.jpg")

        # Display the frame
        cv2.imshow('Register Face', frame)

        # Break the loop if 'q' is pressed
        if event.is_set():
            break

    # Release the video capture and close the OpenCV windows
    cap.release()
    cv2.destroyAllWindows()
    print("Webcam released. Script finished.")

if __name__ == "__main__":
    name = input("Enter the name for registration: ")
    event = threading.Event()  # Create an event for synchronization
    register_face(name)
