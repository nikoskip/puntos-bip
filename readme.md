# Consulta Puntos Bip!

App que permite buscar Puntos Bip! cercanos a una dirección.

## Requisitos

La App está desarrollada con Laravel 5.2, favor revisar los [requerimientos del framework](https://laravel.com/docs/5.2/installation).

## Instalación

1. Clonar el proyecto e instalar las dependencias (`composer install` y `npm install`)
2. Generar los assets con Gul: `gulp` o `gulp --production` si se requieren minificados
3. Generar archivo `.env` con los datos de acceso para la base de datos
4. Obtener la llave para cifrado (aunque no la utilicemos): `php artisan key:generate`
5. Crear el modelo de datos en la base de datos: `php artisan migrate`
6. Crear carpeta `private` donde se descargan los archivos XLS con los Puntos Bip!: `mkdir storage/app/private && chmod 777 storage/app/private`
7. Obtener los Puntos Bip! desde la API de datos.gob.cl: `php artisan puntosbip:actualizar-api`
8. Como no todos los Puntos Bip! tienen acceso mediante API, el resto se procesa desde sus archivos XLS: `php artisan puntosbip:actualizar-file`

Para configurar el radio de búsqueda de Puntos Bip!, se debe modificar la llave `radio_busqueda` en el archivo `config/app.php`. Por defecto son `500` metros.

## API

Existe una API muy simple para poder obtener los Puntos Bip! de acuerdo a una dirección o coordenadas dadas.

**/api/getByAddress?address={address}**
Retorna JSON con el listado de Puntos Bip! cercanos para la dirección dada (se utiliza la API de Google Maps para obtener las coordenadas).

**/api/getByLocation?lat={lat}&lon={lon}**
Retorna JSON con el listado de Puntos Bip! cercanos para las coordenadas dadas.

**Ejemplo de respuesta**

Request: /api/getByAddress?address=Av.+Apoquindo+3000
```json
{
   "status":"ok",
   "results":[
      {
         "nombre":"TOBALABA L4",
         "direccion":"Avda. 11 de Septiembre N\u00b0 2700",
         "comuna":"Providencia",
         "horario":"Lunes a Viernes: 6:00 a 23:00 horas\nS\u00e1bados: 6:30 a 22:30 horas\nDomingos y festivos: 8:00 a 22:30 ho",
         "servicios":[
            "Carga remota",
            "Venta de tarjeta"
         ],
         "distance":47
      },
      {
         "nombre":"TOBALABA L1",
         "direccion":"Avda. 11 de Septiembre N\u00b0 2700",
         "comuna":"Providencia",
         "horario":"Lunes a Viernes: 6:00 a 23:00 horas\nS\u00e1bados: 6:30 a 22:30 horas\nDomingos y festivos: 8:00 a 22:30 ho",
         "servicios":[
            "Carga remota",
            "Venta de tarjeta"
         ],
         "distance":55
      },
      {
         "nombre":null,
         "direccion":"AV. PROVIDENCIA 2382",
         "comuna":"PROVIDENCIA",
         "horario":"Lun a Sab. 08:00 a 21:00 Dom y Festivos 09:00 a 14:00",
         "servicios":[
            "Carga remota",
            "Venta de tarjeta",
            "Consulta de saldo",
            "Activaci\u00f3n carga remota"
         ],
         "distance":495
      }
   ]
}
```

En caso de error en la llamada (dirección no encontrada, API de Google Maps no responde), la API responde en el campo `status` con `invalid` y agrega un campo `error_message` notificando el motivo. 