<?php

$conn = mysqli_connect("localhost", "root", "", "crud_db");

if(!$conn){
    die("koneksi gagal: ". msqli_connect_error());
}

?>