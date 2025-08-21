import cv2
import serial
import time

arduino = serial.Serial('COM17', 9600)  # Ajuste 'COM' para a porta correta no sistema
time.sleep(2)

#Haar Cascade para detecção de rostos
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

#Inicializa a câmera
cap = cv2.VideoCapture(0)

#Configura a resolução da câmera
cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1920)
cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 1080)

if not cap.isOpened():
    print("Erro ao abrir a câmera")
    exit()

while True:
    ret, frame = cap.read()
    if not ret:
        print("Erro ao capturar o frame")
        break

    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    faces = face_cascade.detectMultiScale(gray, 1.3, 5)

    # Array para armazenar as coordenadas
    coordinates = []

    if len(faces) > 0:
        largest_face = max(faces, key=lambda rect: rect[2] * rect[3])
        (x, y, w, h) = largest_face
        cv2.rectangle(frame, (x, y), (x + w, y + h), (255, 0, 0), 2)
        face_x = x + w // 2
        face_y = y + h // 2


        coordinates.append(face_x)
        coordinates.append(face_y)

    if coordinates:
        # Enviar coordenadas para o Arduino como string
        command = ",".join(map(str, coordinates)) + "\n"
        print(f"Sending coordinates to Arduino: {command}")
        arduino.write(command.encode())

    cv2.imshow('frame', frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):  # Pressione 'q' para sair
        break


cap.release()
cv2.destroyAllWindows()
arduino.close()