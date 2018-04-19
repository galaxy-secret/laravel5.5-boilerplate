<?php

return [


    /**
     * ---------------------------------------------------------------------
     * gnupg_home: 在Linux上生成或导入的秘钥的路径， 切记，此目录最好是www:www
     *              因为 web 方式运行 php 通常是以 www 为用户和用户组
     *              当然如果是以其他的用户名和用户组，权限也要改成相应的
     * private_key_fingerprint: 私钥指纹
     * public_key_fingerprint: 公钥指纹
     * ---------------------------------------------------------------------
     */

    'gpg' => [
        'gnupg_home' => 'GNUPGHOME=/home/wwwroot/mysize.io/.gnupg',
        'private_key_fingerprint' => 'private_key_fingerprint',
        'public_key_fingerprint' => 'public_key_fingerprint',
    ],

];
