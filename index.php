<?php

require './library/vendor/autoload.php'; // include Composer's autoloader
// membuat koneksi ke mogo server
$client     = new MongoDB\Client("mongodb://localhost:27017");
// memilih database yang ingin digunakan
$db         = $client->sipasti;
// memilih collecttion
$col        = $db->tblog;
// insert data ke colection
//$result = $col->insertOne( [ 'name' => 'Nuris Akbar'] );

//echo "Inserted with Object ID '{$result->getInsertedId()}'";

$find       = $col->find(
    [
        'username'  => 'HymanParisianMD'
    ],
    [
    'projection' => [
        'username' => 1, '_id' => 1
    ],
    'limit' => 2
    ]
);


$dd = [];
foreach($find as $d){

    $dd[] = [
        'id'    => $d->_id,
        'user'  => $d->username
    ];

}

print_r($dd);

exit;

$count = $col->count([
    'limit' => 5,
    'projection' => [
        'username' => 1,
        'namaLengkap' => 1
    ],
]);

echo $count;

exit;

$faker_ = new Faker\Factory();

$faker = $faker_::create();

try {

    ///for testing insert data

    //$password	= $this->enkripsi_password('passcobacoba');

    $insert = [];

    $last   = [];

    for ($i = 0; $i < 20; $i++) {

        $name		= $faker->name();

        $username	= str_replace(" ", "", $name);

        $insert[] = [
            'username'		=> $username,
            'namaLengkap'	=> $name,
            'emailUser'		=> $faker->email(),
            'password'		=> md5(time()),
            'tglRegister'	=> date('Y-m-d H:i:s')
        ];

    }

    $in = $col->insertMany($insert);

    if($in){

        print_r($in->getInsertedId());
    }

} catch (\Exception $e) {

    echo $e->getMessage();
} finally {
    echo 'Selesai';
}