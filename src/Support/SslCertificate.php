<?php

/** @noinspection PhpComposerExtensionStubsInspection */

namespace NormanHuth\Library\Support;

use JetBrains\PhpStorm\ExpectedValues;
use OpenSSLAsymmetricKey;

class SslCertificate
{
    /**
     * The Certificate Instance.
     */
    protected string $certificate;

    /**
     * The Private Key Instance.
     */
    protected string $privateKey;

    /**
     * The Certificate passphrase.
     */
    protected ?string $passphrase;

    protected OpenSSLAsymmetricKey|bool $openSSLAsymmetricKey;

    public function __construct(string $certificate, ?string $privateKey = null, ?string $passphrase = null)
    {
        $this->passphrase = $passphrase;

        if (file_exists($certificate)) {
            $certificate = file_get_contents($certificate);
        }

        $this->certificate = $certificate;

        if (!$privateKey) {
            return;
        }

        if (file_exists($privateKey)) {
            $privateKey = file_get_contents($privateKey);
        }

        $this->privateKey = $privateKey;
    }

    /**
     * Get the X.509 certificate fingerprint.
     *
     * @param  bool  $binary  When set to 'true', outputs raw binary data. 'False' outputs lowercase hexits.
     */
    public function getFingerprint(
        #[ExpectedValues(values: [
            'blake2b512',
            'blake2s256',
            'md4',
            'md5',
            'md5-sha1',
            'mdc2',
            'ripemd160',
            'sha1',
            'sha224',
            'sha256',
            'sha3-224',
            'sha3-256',
            'sha3-384',
            'sha3-512',
            'sha384',
            'sha512',
            'sha512-224',
            'sha512-256',
            'shake128',
            'shake256',
            'sm3',
            'whirlpool',
        ])]
        string $digestAlgorithm = 'sha1',
        bool $encodedAsBase64 = true,
        bool $binary = false
    ): bool|string {
        $fingerprint = openssl_x509_fingerprint($this->certificate, $digestAlgorithm, $binary);

        if (!$fingerprint) {
            return $fingerprint;
        }

        if ($encodedAsBase64) {
            return base64_encode(pack('H*', $fingerprint));
        }

        return $fingerprint;
    }

    public function getCertificate(bool $justBase64 = true): array|bool|string
    {
        if ($justBase64) {
            return str_replace(
                ["\n", '-----BEGIN CERTIFICATE-----', '-----END CERTIFICATE-----'],
                '',
                $this->certificate
            );
        }

        return $this->certificate;
    }

    /**
     * Get OpenSSLAsymmetricKey Private Key Resource.
     */
    public function getOpenSSLAsymmetricKey(): OpenSSLAsymmetricKey|bool
    {
        if (!isset($this->openSSLAsymmetricKey)) {
            $this->openSSLAsymmetricKey = openssl_pkey_get_private($this->privateKey, $this->passphrase);
        }

        return $this->openSSLAsymmetricKey;
    }

    /**
     * Get generated signature.
     */
    public function getPkGeneratedSignature(array|string $payload, array|string $headers = []): string
    {
        if (is_array($payload)) {
            $payload = Jwt::urlSafeBase64Encode($payload);
        }
        if (is_array($headers)) {
            $headers = Jwt::urlSafeBase64Encode($headers);
        }

        openssl_sign($headers . '.' . $payload, $signature, $this->getOpenSSLAsymmetricKey(), 'sha256');

        return $signature;
    }
}
