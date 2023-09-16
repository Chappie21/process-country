<?php
class CountryController
{   
    private $countries = [
        'argentina',
        'colombia',
        'españa',
        'méxico',
        'perú',
        'chile',
        'venezuela'
    ];

    private $timezones = [
        'argentina' => 'America/Argentina/Buenos_Aires',
        'colombia' => 'America/Bogota',
        'españa' => 'Europe/Madrid',
        'méxico' => 'America/Mexico_City',
        'perú' => 'America/Lima',
        'chile' => 'America/Santiago',
        'venezuela' => "America/Caracas"
    ];

    public function getSupportedCountries() {
        return $this->countries;
    }

    public function processCountry($country)
    {
        // Establecer la zona horaria del servidor en función del país
        $this->setTimezone($country);

        // Obtener la hora actual del país
        $time = $this->getCurrentTime();

        // Generar el saludo en función de la hora
        $greeting = $this->generateGreeting($time);

        return $greeting;
    }

    public function setTimezone($country)
    {
        // Verificar si la zona horaria del país está definida
        if (isset($this->timezones[$country])) {
            date_default_timezone_set($this->timezones[$country]);
        }
    }

    public function getCurrentTime()
    {
        // Obtener la hora actual en función de la zona horaria establecida
        $time = date('H:i');
        return $time;
    }

    private function generateGreeting($time)
    {
        // Generar el saludo en función de la hora
        $hour = (int)substr($time, 0, 2);

        if ($hour >= 6 && $hour < 12) {
            return 'Buenos días';
        } elseif ($hour >= 12 && $hour < 18) {
            return 'Buenas tardes';
        } else {
            return 'Buenas noches';
        }
    }
}
?>