# 🤖 Robô Atendente Cleiton

**Cleiton** é um robô atendente físico projetado para simular interações com o público de forma simpática, acessível e interativa. Este projeto integra **visão computacional**, **controle mecânico com Arduino**, **impressão 3D** e **expressividade facial**, com o objetivo de explorar formas inovadoras de atendimento automatizado em eventos, feiras, instituições ou ambientes educacionais.

---

## 🎯 Objetivo

Desenvolver uma plataforma robótica acessível e extensível, que:

- Detecte rostos humanos em tempo real
- Mova partes do rosto (olhos e pálpebras) de forma expressiva
- Realize movimentos programados por comandos recebidos via computador
- Reaja de forma simples a estímulos visuais (posição do rosto)
- Sirva como base para sistemas interativos de atendimento automatizado

---

## 🧠 Funcionalidades

- 👁️ **Visão computacional com OpenCV** para detectar rostos e enviar coordenadas ao Arduino
- ⚙️ **Controle mecânico de servos** para mover olhos e pálpebras do robô
- 🧃 **Arquivos `.gcode`** para impressão 3D de partes como olhos e estrutura do rosto
- 🧩 **Código modular** com Python, Arduino e G-code para integração entre software e hardware

---

## 🛠️ Tecnologias Utilizadas

| Tecnologia | Função |
|------------|--------|
| `Python + OpenCV` | Detecção de rostos em tempo real |
| `Arduino (cleiton_robo.ino)` | Controle de motores (olhos e pálpebras) via sinais seriais |
| `G-code (Impressão 3D)` | Modelagem e movimentação das partes impressas |
| `Serial (USB)` | Comunicação entre computador e microcontrolador |
| `cv2.CascadeClassifier` | Uso de HaarCascade para localizar rostos |

---

## 🧪 Estrutura do Projeto


---

## 🚀 Como Executar

### 1. Configurar o Arduino
- Carregue o arquivo `cleiton_robo.ino` na sua placa (por exemplo, Arduino Uno)
- Conecte os servos nos pinos corretos definidos no código
- Conecte via USB ao seu computador

### 2. Rodar o código Python
- Instale as dependências:

```bash
pip install opencv-python pyserial
