#include <Wire.h>
#include <Adafruit_MLX90614.h>

Adafruit_MLX90614 mlx = Adafruit_MLX90614();

//منفذ الريلاي
#define RELAY_PIN 9

// إعدادات الجهاز
const float HUMAN_TEMP_MIN = 35.0; // الحد الأدنى لحرارة جلد الإنسان
const float HUMAN_TEMP_MAX = 37.5; // الحد الأقصى لحرارة جلد الإنسان
const int PUMP_DURATION = 1000;    // مدةتشغيل المضخة (2 ثانية)
const int MIN_INTERVAL = 1000;    

unsigned long lastPumpTime = 0;
bool isPumpActive = false;

void setup() {
  // إعداد المستشعر
  mlx.begin();

  // إعداد منفذ الريلاي
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, LOW); // تأكد من أن المضخة متوقفة في البداية

  Serial.begin(9600);
  Serial.println("System initialized...");
}

void loop() {
  // قراءة درجة حرارة الجسم
  float objectTemp = mlx.readObjectTempC();


  Serial.print("Object Temperature: ");
  Serial.println(objectTemp);

  // التحقق من استشعار اليد
  if (objectTemp >= HUMAN_TEMP_MIN && objectTemp <= HUMAN_TEMP_MAX) {
    if (!isPumpActive && (millis() - lastPumpTime > MIN_INTERVAL)) {
      activatePump(); // تشغيل المضخة
    }
  }

  // تأخير بسيط قبل القراءة التالية
  delay(2000);
}

void activatePump() {

  isPumpActive = true;

  // تشغيل المضخة
  Serial.println("Pump activated!");
  digitalWrite(RELAY_PIN, HIGH);
  delay(PUMP_DURATION);
  digitalWrite(RELAY_PIN, LOW);
  Serial.println("Pump deactivated!");

  isPumpActive = false;
  lastPumpTime = millis();
}
