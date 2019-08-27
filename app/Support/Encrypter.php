<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Support;

use Exception;

/**
 * Class Encrypter
 * @package App\Support
 */
class Encrypter
{
    /**
     * The encryption key.
     *
     * @var string
     */
    protected $key;

    /**
     * The algorithm used for encryption.
     *
     * @var string
     */
    protected $cipher;

    /**
     * A non-NULL Initialization Vector.
     *
     * @var string
     */
    protected $iv;

    /**
     * Create a new encrypter instance.
     *
     * @param $key
     * @param string $cipher
     * @throws Exception
     */
    public function __construct($key, $cipher = 'AES-256-CBC')
    {
        if (substr($key, 0, 7) === 'base64:') {
            $key = base64_decode(substr($key, 7));
        }

        $key = (string)$key;

        if (static::supported($key, $cipher)) {
            $this->key = $key;
            $this->cipher = $cipher;
        } else {
            throw new Exception('The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths.');
        }
    }

    /**
     * Determine if the given key and cipher combination is valid.
     *
     * @param  string $key
     * @param  string $cipher
     * @return bool
     */
    public static function supported($key, $cipher)
    {
        $length = mb_strlen($key, '8bit');

        return ($cipher === 'AES-128-CBC' && $length === 16) ||
            ($cipher === 'AES-256-CBC' && $length === 32);
    }

    /**
     * Create a new encryption key for the given cipher.
     *
     * @param string $cipher
     * @param bool $isBase64
     * @return string
     * @throws \Exception
     */
    public static function generateKey($cipher = 'AES-256-CBC', $isBase64 = true)
    {
        $keys = random_bytes($cipher == 'AES-128-CBC' ? 16 : 32);
        if ($isBase64) {
            return 'base64:' . base64_encode($keys);
        }
        return $keys;
    }

    /**
     * Create a new encryption vector for the given cipher.
     *
     * @param string $cipher
     * @param bool $isBase64
     * @return string
     * @throws Exception
     */
    public static function generateIv($cipher = 'AES-256-CBC', $isBase64 = true)
    {
        $keys = random_bytes(openssl_cipher_iv_length($cipher));
        if ($isBase64) {
            return 'base64:' . base64_encode($keys);
        }
        return $keys;
    }

    /**
     * Set a Vector.
     * @param $iv
     * @return bool
     */
    public function setIv($iv)
    {
        if (substr($iv, 0, 7) === 'base64:') {
            $iv = base64_decode(substr($iv, 7));
        }

        if (openssl_cipher_iv_length($this->cipher) != strlen($iv)) {
            return false;
        }

        $this->iv = $iv;
        return true;
    }

    /**
     * Encrypt the given value.
     *
     * @param $value
     * @param bool $isDynamic
     * @return string
     * @throws Exception
     */
    public function encrypt($value, $isDynamic = false)
    {
        $iv = $this->iv && !$isDynamic ? $this->iv : random_bytes(openssl_cipher_iv_length($this->cipher));

        // First we will encrypt the value using OpenSSL. After this is encrypted we
        // will proceed to calculating a MAC for the encrypted value so that this
        // value can be verified later as not having been changed by the users.
        $value = \openssl_encrypt($value, $this->cipher, $this->key, 0, $iv);

        if ($value === false) {
            throw new Exception('Could not encrypt the data.');
        }

        /**
         * No dynamic encrypt return shot string
         */
        if ($this->iv && !$isDynamic) {
            return base64_encode($value);
        }

        // Once we get the encrypted value we'll go ahead and base64_encode the input
        // vector and create the MAC for the encrypted value so we can then verify
        // its authenticity. Then, we'll JSON the data into the "payload" array.
        $mac = $this->hash($iv = base64_encode($iv), $value);

        $json = json_encode(compact('iv', 'value', 'mac'));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Could not encrypt the data.');
        }

        return base64_encode($json);
    }

    /**
     * Decrypt the given value.
     *
     * @param $payload
     * @param bool $isDynamic
     * @return string
     * @throws Exception
     */
    public function decrypt($payload, $isDynamic = false)
    {
        if ($this->iv && !$isDynamic) {
            // Here we will decrypt the value. If we are able to successfully decrypt it
            // we will then unserialize it and return it out to the caller. If we are
            // unable to decrypt this value we will throw out an exception message.
            $decrypted = \openssl_decrypt(base64_decode($payload), $this->cipher, $this->key, 0, $this->iv);
        } else {
            $payload = $this->getJsonPayload($payload);

            $iv = base64_decode($payload['iv']);

            // Here we will decrypt the value. If we are able to successfully decrypt it
            // we will then unserialize it and return it out to the caller. If we are
            // unable to decrypt this value we will throw out an exception message.
            $decrypted = \openssl_decrypt($payload['value'], $this->cipher, $this->key, 0, $iv);
        }


        if ($decrypted === false) {
            throw new Exception('Could not decrypt the data.');
        }

        return $decrypted;
    }

    /**
     * Create a MAC for the given value.
     *
     * @param  string $iv
     * @param  mixed $value
     * @return string
     */
    protected function hash($iv, $value)
    {
        return hash_hmac('sha256', $iv . $value, $this->key);
    }

    /**
     * Get the JSON array from the given payload.
     *
     * @param $payload
     * @return mixed
     * @throws \Exception
     */
    protected function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);

        // If the payload is not valid JSON or does not have the proper keys set we will
        // assume it is invalid and bail out of the routine since we will not be able
        // to decrypt the given value. We'll also check the MAC for this encryption.
        if (!$this->validPayload($payload)) {
            throw new Exception('The payload is invalid.');
        }

        if (!$this->validMac($payload)) {
            throw new Exception('The MAC is invalid.');
        }

        return $payload;
    }

    /**
     * Verify that the encryption payload is valid.
     *
     * @param  mixed $payload
     * @return bool
     */
    protected function validPayload($payload)
    {
        return is_array($payload) && isset($payload['iv'], $payload['value'], $payload['mac']) &&
            strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length($this->cipher);
    }

    /**
     * Determine if the MAC for the given payload is valid.
     *
     * @param array $payload
     * @return bool
     * @throws \Exception
     */
    protected function validMac(array $payload)
    {
        $calculated = $this->calculateMac($payload, $bytes = random_bytes(16));

        return hash_equals(
            hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated
        );
    }

    /**
     * Calculate the hash of the given payload.
     *
     * @param  array $payload
     * @param  string $bytes
     * @return string
     */
    protected function calculateMac($payload, $bytes)
    {
        return hash_hmac(
            'sha256', $this->hash($payload['iv'], $payload['value']), $bytes, true
        );
    }

    /**
     * Get the encryption key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
