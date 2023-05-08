<?php
class AES {
    private $key = 'WEG0qKxgIxhw8nCpClmg6DAkc9ndFArg';
    private $cipher = 'aes-256-cbc';
    private $iv = '6RLhCtqRgMGpfq7jjPdUmg==';

    public function encrypt($data) {
        // Encrypt the data using the encryption key, algorithm, mode, and IV
        $encrypted_data = openssl_encrypt($data, $this->cipher, $this->key, 0, base64_decode($this->iv));

        // Return the encrypted data and IV
        return base64_encode($encrypted_data);
    }

    public function decrypt($encrypted_data, $iv) {
        // Decrypt the data using the decryption key, algorithm, mode, and IV
        $decrypted_data = openssl_decrypt(base64_decode($encrypted_data), $this->cipher, $this->key, 0, base64_decode($iv));

        // Return the decrypted data
        return $decrypted_data;
    }
}
?>