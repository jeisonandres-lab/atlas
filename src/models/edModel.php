<?php
namespace App\Atlas\models;

class edModel{
    private $data;
    private $key = 'tu_clave_secreta';
    public function encriptar(string $parametro){
            // Debe ser una cadena de bytes de longitud fija
            // Cifrar los datos usando AES en modo CBC
            $this->getData($parametro);
            $ivlen = openssl_cipher_iv_length('aes-256-cbc');
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext = openssl_encrypt($this->data, 'aes-256-cbc', $this->key,
            0, $iv);
            echo $ciphertext.":";
            // Guardar el IV para el descifrado
            $ciphertext_base64 = base64_encode($iv.$ciphertext);

            // Desencriptar los datos
            $ciphertext_dec = base64_decode($ciphertext_base64);
            $ivlen = openssl_cipher_iv_length('aes-256-cbc');
            $iv = substr($ciphertext_dec, 0, $ivlen);
            $plaintext_dec = openssl_decrypt(substr($ciphertext_dec, $ivlen), 'aes-256-cbc', $this->key, 0, $iv);

            echo $plaintext_dec;
    }

    public function getData(string $parametro){
        $this->data = $parametro;
    }
}