<?php
/**
 * Created by PhpStorm.
 * User: duanbin
 * Date: 2018/4/17 11:22
 */

namespace App\Utils\GnuPG;


final class GnuPGConfig
{

    private $__public_key_fingerprint = '';
    private $__private_key_fingerprint = '';

    private $__gnupg_home = '';
    private $__sign_mode;

    public function __construct($sign_mode = GNUPG_SIG_MODE_DETACH)
    {
        $gpg_config = config('gnupg.gpg');
        $this->__gnupg_home = $gpg_config['gnupg_home'];
        $this->__sign_mode = $sign_mode;

        $this->setPrivateKeyFingerprint($gpg_config['private_key_fingerprint']);
        $this->setPublicKeyFingerprint($gpg_config['public_key_fingerprint']);
    }

    /**
     * @return string
     */
    public function getPrivateKeyFingerprint(): string
    {
        return $this->__private_key_fingerprint;
    }

    /**
     * @param string $private_key_fingerprint
     * @return GnuPGConfig
     */
    public function setPrivateKeyFingerprint(string $private_key_fingerprint): GnuPGConfig
    {
        $this->__private_key_fingerprint = $private_key_fingerprint;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKeyFingerprint(): string
    {
        return $this->__public_key_fingerprint;
    }

    /**
     * @param string $public_key_fingerprint
     * @return GnuPGConfig
     */
    public function setPublicKeyFingerprint(string $public_key_fingerprint): GnuPGConfig
    {
        $this->__public_key_fingerprint = $public_key_fingerprint;
        return $this;
    }

    /**
     * @return string
     */
    public function getGnuPGHome(): string
    {
        return $this->__gnupg_home;
    }

    /**
     * @param string $gnupg_home
     * @return GnuPGConfig
     */
    public function setGnuPGHome(string $gnupg_home): GnuPGConfig
    {
        $this->__gnupg_home = $gnupg_home;
        return $this;
    }

    /**
     * @return int
     */
    public function getSignMode(): int
    {
        return $this->__sign_mode;
    }

    /**
     * @param int $sign_mode
     * @return GnuPGConfig
     */
    public function setSignMode(int $sign_mode): GnuPGConfig
    {
        $this->__sign_mode = $sign_mode;
        return $this;
    }

}