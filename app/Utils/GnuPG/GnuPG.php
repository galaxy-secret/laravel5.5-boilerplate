<?php
/**
 * Created by PhpStorm.
 * User: duanbin
 * Date: 2018/4/17 13:09
 */

namespace App\Utils\GnuPG;


class GnuPG
{
    private $__config;
    private $__gpg;

    public function __construct(GnuPGConfig $c)
    {
        $this->__config = $c;
        putenv($c->getGnuPGHome());
        $this->__gpg = new \gnupg();
        $this->__gpg->seterrormode(GNUPG_ERROR_EXCEPTION);
        $this->__gpg->setsignmode($c->getSignMode());
    }

    /**
     * 使用私钥进行签名
     * @param string $plaintext
     * @return array|string
     * @author duanbin
     * @date 2018/4/17 18:48
     */
    public function sign(string $plaintext)
    {
        try{
            $this->__gpg->addsignkey($this->__config->getPrivateKeyFingerprint());
            return $this->__gpg->sign($plaintext);
        }catch (\Exception $exception) {
            return [ 'code' => $exception->getCode(), 'message' => $exception->getMessage() ];
        }
    }

    /**
     * 验证签名
     * @param $signed_text
     * @param $signature
     * @return array|bool
     * @author duanbin
     * @date 2018/4/17 18:48
     */
    public function verify(string $signed_text, string $signature)
    {
        try{
            $info = $this->__gpg->verify($signed_text,$signature);
            return $this->__config->getPrivateKeyFingerprint() === $info[0]['fingerprint'] ? true: false;
        }catch (\Exception $exception) {
            return [ 'code' => $exception->getCode(), 'message' => $exception->getMessage() ];
        }
    }

    /**
     * 签名且加密
     * @param string $plaintext
     * @return array|string
     * @author duanbin
     * @date 2018/4/19 15:51
     */
    public function encryptSign(string $plaintext)
    {
        try{
            $private_key_fingerprint = $this->__config->getPrivateKeyFingerprint();
            $this->__gpg->addencryptkey($private_key_fingerprint);
            $this->__gpg->addsignkey($private_key_fingerprint);
            return $info = $this->__gpg->encryptsign($plaintext);
        }catch (\Exception $exception) {
            return [ 'code' => $exception->getCode(), 'message' => $exception->getMessage() ];
        }
    }

    /**
     * 解密并验证签名
     * @param string $encrypted_signed_text
     * @return array|bool
     * @author duanbin
     * @date 2018/4/19 16:08
     */
    public function decryptVerify(string $encrypted_signed_text)
    {
        try{
            $plaintext = '';
            $private_key_fingerprint = $this->__config->getPrivateKeyFingerprint();
            $this->__gpg->adddecryptkey($private_key_fingerprint, '');
            $info = $this->__gpg->decryptverify($encrypted_signed_text, $plaintext);
            return $private_key_fingerprint === $info[0]['fingerprint'] ? true: false;
        }catch (\Exception $exception) {
            return [ 'code' => $exception->getCode(), 'message' => $exception->getMessage() ];
        }
    }

    /**
     * 加密
     * @param string $plaintext
     * @return array|string
     * @author duanbin
     * @date 2018/4/19 16:09
     */
    public function encrypt(string $plaintext)
    {
        try{
            $this->__gpg->addencryptkey($this->__config->getPrivateKeyFingerprint());
            return $info = $this->__gpg->encrypt($plaintext);
        }catch (\Exception $exception) {
            return [ 'code' => $exception->getCode(), 'message' => $exception->getMessage() ];
        }
    }

    /**
     * 解密
     * @param $encrypted_signed_text
     * @return array|string
     * @author duanbin
     * @date 2018/4/19 16:09
     */
    public function decrypt($encrypted_signed_text)
    {
        try{
            $private_key_fingerprint = $this->__config->getPrivateKeyFingerprint();
            $this->__gpg->adddecryptkey($private_key_fingerprint, '');
            return $this->__gpg->decrypt($encrypted_signed_text);
        }catch (\Exception $exception) {
            return [ 'code' => $exception->getCode(), 'message' => $exception->getMessage() ];
        }
    }


    /**
     * @return \App\Utils\GnuPG\GnuPGConfig
     */
    public function getConfig(): \App\Utils\GnuPG\GnuPGConfig
    {
        return $this->__config;
    }

    /**
     * @param \App\Utils\GnuPG\GnuPGConfig $config
     * @return GnuPG
     */
    public function setConfig(\App\Utils\GnuPG\GnuPGConfig $config): GnuPG
    {
        $this->__config = $config;
        return $this;
    }

}