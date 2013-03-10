<?php

require_once('init.php');

function create_user($username, $email, $pass)
{
    $user = R::findOne("user", "username = ? or email = ?", array($username, $email));

    if (!isset($user)) {
        try {
            $user = R::dispense('user');

            $user->username = $username;
            $user->email = $email;
            $user->salt = time() + rand();
            $user->password = sha1($user->username . $pass . $user->email . $user->salt);

            R::store($user);

            print($user);

        } catch (Exception $ex) {
        }
    }
}

function create_data_row($received_data, $user)
{
    if (isset($received_data) && isset($user) && $user != null && $received_data != null && strlen($received_data) > 0) {
        $received_data = substr($received_data, 1, mb_strlen($received_data, "UTF-8") - 2);
        $received_data = explode('|', $received_data);

        $wc_id = substr($received_data[0], 0, 2);
        $component_id = substr($received_data[0], 2, 2);
        $status = substr($received_data[0], 4, 1);
        $date = substr($received_data[1], 0, 6);
        $time = substr($received_data[1], 6, 6);

        $duration = $received_data[2];

        $data_row = R::dispense('data');

        $data_row->user = $user;
        $data_row->wc_id = $wc_id;
        $data_row->component_id = $component_id;
        $data_row->status = $status;
        $data_row->date = $date;
        $data_row->time = $time;
        $data_row->duration = $duration;

        R::store($data_row);

        print($data_row);
    }
}

require_once("lib/pChart/class/pData.class.php");
require_once("lib/pChart/class/pDraw.class.php");
require_once("lib/pChart/class/pImage.class.php");

function draw_usage_chart($username)
{
    if (isset($username) && strlen($username) > 0) {
        $user = R::findOne('user', 'username = ?', array($username));

        $STATUS_ON = 1;

        $component_total = R::getCell("select count(distinct(component_id)) from data");

        $FLOW_01 = 8 / 60;
        $FLOW_02 = 10 / 60;
        $FLOW_03 = 18 / 60;

        $data = array();
        $flow = array();

        for ($i = 1; $i < $component_total + 1; $i++) {
            $component_id = str_pad($i, 2, '0', STR_PAD_LEFT);

            $data[$component_id] = R::findAll('data', 'where user_id = ? and status = ? and component_id = ?', array($user->id, $STATUS_ON, $component_id));

            $flow_value_name = 'FLOW_' . $component_id;
            $flow[$component_id] = array();

            foreach ($data[$component_id] as $line) {
                $time = (int)substr($line->duration, 0, 2) * 60 + (int)substr($line->duration, 2, 2);

                array_push($flow[$component_id], $time * $$flow_value_name);
            }
        }

        foreach ($flow as $line) {
            echo "<ul>";

            foreach ($line as $value) {
                echo "<li>$value Litros</li>";
            }

            echo "</ul>";
        }

        $chartData = new pData();

    }
}
