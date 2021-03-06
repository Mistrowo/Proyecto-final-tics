void setup()
{
  //pinMode(LED_BUILTIN, OUTPUT);
  Serial.begin(9600);
  pinMode(7, OUTPUT); //led
  pinMode(8, OUTPUT); //Regadio
  pinMode(4, OUTPUT); //LUZ 5v
  pinMode(2, OUTPUT); //Temp 5v
  pinMode(A0, INPUT); //Humedad
  pinMode(A1, INPUT); //Temperatura
  pinMode(A2, INPUT); //Luz
}
int i=1;
int promediotemp = 0;
int promediohumedad = 0;
int promedioluz = 0;
int promedio = 0;
void loop()
{
  //Cada 5 segundos pasaremos el promedio, esto se puede cambiar a minutos inclusive i=60 seria un minuro y i=3600 es una hora
  while (i < 2) {
    //para obtener el porcentaje de humedad utilizamos la sgte conversion:
    int humedad = analogRead(A0) / 10;
  
    //obtencion de temperatura en celcius
    int temp = analogRead(A1);
    temp = temp * (500.0 / 1023.0);
  
    //obtener inteisidad de luz a traves del LDR
    int luz = analogRead(A2);
    //Control de regadio primero por baja humedad y sus condiciones posteriores
    if ((humedad < 60)) {
      digitalWrite(8, HIGH);
      digitalWrite(7, HIGH);
      if (temp > 24) {
        digitalWrite(8, LOW);
        digitalWrite(7, LOW);
      }
    } else {
      digitalWrite(8, LOW);
      digitalWrite(7, LOW);
      if (temp > 28 && humedad < 65) {
        digitalWrite(8, HIGH);
        digitalWrite(7, HIGH);
      }
    }
    i=i+1;
    if(temp!=0 && humedad!=0){
      promediotemp=promediotemp+temp;
      promediohumedad=promediohumedad+humedad;
      promedioluz=promedioluz+luz;
      promedio=promedio+1;
    }
    delay(1000);
  }
  if(promediotemp != 0 && promediohumedad!=0){
    Serial.print(promediotemp/promedio);
    Serial.print(",");
    Serial.print(promediohumedad/promedio);
    Serial.print(",");
    Serial.println(promedioluz/promedio);
    i=0;
    promedio=0;
    promediotemp=0;
    promediohumedad=0;
    promedioluz=0;
  }
  i=0;
  
  
}
