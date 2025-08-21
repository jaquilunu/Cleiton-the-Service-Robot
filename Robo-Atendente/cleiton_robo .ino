#include <Servo.h>

#define P_SERVO_DIRECAO_X 8
#define P_SERVO_DIRECAO_Y 9
#define P_SERVO_PALPEBRA_ESQUERDO_BAIXO 10
#define P_SERVO_PALPEBRA_ESQUERDO_CIMA 11
#define P_SERVO_PALPEBRA_DIREITO_CIMA 12
#define P_SERVO_PALPEBRA_DIREITO_BAIXO 13


#define POS_MIN_DIRECAO_X 15
#define POS_MAX_DIRECAO_X 67

#define POS_MIN_DIRECAO_Y 118
#define POS_MAX_DIRECAO_Y 144

#define POS_ABERTO_PALPEBRA_ESQUERDO_BAIXO 170
#define POS_FECHADO_PALPEBRA_ESQUERDO_BAIXO 138

#define POS_ABERTO_PALPEBRA_ESQUERDO_CIMA 0
#define POS_FECHADO_PALPEBRA_ESQUERDO_CIMA 70

#define POS_ABERTO_PALPEBRA_DIREITO_CIMA 170
#define POS_FECHADO_PALPEBRA_DIREITO_CIMA 97

#define POS_ABERTO_PALPEBRA_DIREITO_BAIXO 0
#define POS_FECHADO_PALPEBRA_DIREITO_BAIXO 41

#define posicao_inicial_X  45
#define posicao_inicial_Y  45
#define posicao_repouso_palpebra  45

#define tempo_min_piscada 4500
#define tempo_max_piscada 10000

Servo servoX;
Servo servoY;
Servo servo_palpebra_esquerda_cima;
Servo servo_palpebra_direita_cima;
Servo servo_palpebra_direita_baixo;
Servo servo_palpebra_esquerda_baixo;

unsigned long ULTIMA_ATIVACAO_PALPEBRAS = 0;
unsigned long INTERVALO_ULTIMA_ATIVACAO = 0;
const unsigned long INTERVALO_DESLIGAMENTO = 5000;

void setup() {
  Serial.begin(9600);

  servoX.attach(P_SERVO_DIRECAO_X);
  servoY.attach(P_SERVO_DIRECAO_Y);
  servo_palpebra_esquerda_cima.attach(P_SERVO_PALPEBRA_ESQUERDO_CIMA);
  servo_palpebra_direita_cima.attach(P_SERVO_PALPEBRA_DIREITO_CIMA);
  servo_palpebra_direita_baixo.attach(P_SERVO_PALPEBRA_DIREITO_BAIXO);
  servo_palpebra_esquerda_baixo.attach(P_SERVO_PALPEBRA_ESQUERDO_BAIXO);


  servoX.write((POS_MIN_DIRECAO_X + POS_MAX_DIRECAO_X)/2);
  servoY.write((POS_MIN_DIRECAO_Y + POS_MAX_DIRECAO_Y)/2);
  servo_palpebra_esquerda_cima.write(POS_ABERTO_PALPEBRA_ESQUERDO_CIMA);
  servo_palpebra_direita_cima.write(POS_ABERTO_PALPEBRA_DIREITO_CIMA);
  servo_palpebra_direita_baixo.write(POS_ABERTO_PALPEBRA_DIREITO_BAIXO);
  servo_palpebra_esquerda_baixo.write(POS_ABERTO_PALPEBRA_ESQUERDO_BAIXO);

  randomSeed(analogRead(0));
  INTERVALO_ULTIMA_ATIVACAO = random(tempo_min_piscada, tempo_max_piscada);
}

void loop() {
  int posicao_seguindo_X = 0;
  int posicao_seguindo_Y = 0;

  unsigned long TEMPO_ATUAL_ATIVACAO_PALPEBRA = millis();

  if (Serial.available() > 0) {
    String data = Serial.readStringUntil('\n');
    int commaIndex = data.indexOf(',');

    if (commaIndex > 0) {
      int x = data.substring(0, commaIndex).toInt();
      int y = data.substring(commaIndex + 1).toInt();

      posicao_seguindo_X = map(x, 1280, 0, POS_MIN_DIRECAO_X, POS_MAX_DIRECAO_X);
      posicao_seguindo_Y = map(y, 0, 720, POS_MIN_DIRECAO_Y, POS_MAX_DIRECAO_Y);

      servoX.write(posicao_seguindo_X);
      servoY.write(posicao_seguindo_Y);
    }

  }
  if(TEMPO_ATUAL_ATIVACAO_PALPEBRA - ULTIMA_ATIVACAO_PALPEBRAS >= INTERVALO_ULTIMA_ATIVACAO) {
    ULTIMA_ATIVACAO_PALPEBRAS = TEMPO_ATUAL_ATIVACAO_PALPEBRA;

    PiscarPalpebra();
    INTERVALO_ULTIMA_ATIVACAO = random (tempo_min_piscada, tempo_max_piscada);
  }
  
  // if(millis() - ULTIMA_ATIVACAO_PALPEBRAS >= INTERVALO_DESLIGAMENTO) {
  //   desligamento();
  // }
}

void PiscarPalpebra() {
  servo_palpebra_esquerda_baixo.write(POS_FECHADO_PALPEBRA_ESQUERDO_BAIXO);
  servo_palpebra_esquerda_cima.write(POS_FECHADO_PALPEBRA_ESQUERDO_CIMA);
  servo_palpebra_direita_cima.write(POS_FECHADO_PALPEBRA_DIREITO_CIMA);
  servo_palpebra_direita_baixo.write(POS_FECHADO_PALPEBRA_DIREITO_BAIXO);
  delay(250);
  servo_palpebra_esquerda_baixo.write(POS_ABERTO_PALPEBRA_ESQUERDO_BAIXO);
  servo_palpebra_esquerda_cima.write(POS_ABERTO_PALPEBRA_ESQUERDO_CIMA);
  servo_palpebra_direita_cima.write(POS_ABERTO_PALPEBRA_DIREITO_CIMA);
  servo_palpebra_direita_baixo.write(POS_ABERTO_PALPEBRA_DIREITO_BAIXO);
  
}

// void desligamento(){
//   servo_palpebra_esquerda_baixo.write(POS_FECHADO_PALPEBRA_ESQUERDO_BAIXO);
//   servo_palpebra_esquerda_cima.write(POS_FECHADO_PALPEBRA_ESQUERDO_CIMA);
//   servo_palpebra_direita_cima.write(POS_FECHADO_PALPEBRA_DIREITO_CIMA);
//   servo_palpebra_direita_baixo.write(POS_FECHADO_PALPEBRA_DIREITO_BAIXO);
//   delay(200);
//   servoX.detach();
//   servoY.detach();
//   servo_palpebra_esquerda_cima.detach();
//   servo_palpebra_direita_cima.detach();
//   servo_palpebra_direita_baixo.detach();
//   servo_palpebra_esquerda_baixo.detach();
  
//   while(true) {}
// }