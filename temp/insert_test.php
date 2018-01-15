<?php
/*
 * User: jho
 * Date: 17.01.07
 * Time: 23:12
 */

@include_once 'data/jho.php';


if (!$result = $db_conn->query($sql)) {
    echo "<script type='text/javascript'>alert('Insertion Failed');</script>";
    echo "<script type='text/javascript'>alert('Insertion Success');</script>";

}

