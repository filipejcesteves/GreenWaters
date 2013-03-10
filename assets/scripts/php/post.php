<?php
require_once('session.php');

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    if ($action != 'login' && $action != 'gendata' && !session_is_valid()) {
        $return['error'] = true;
        $return['msg'] = "<p>A sua sessão expirou.</p>";
        $return['page'] = "index.php";

        echo json_encode($return);

        return;
    }

    $action();
}

function login()
{
    $username = $_POST['data']['username'];
    $pass = $_POST['data']['password'];

    $user = R::findOne('user', 'username = ?', array($username));

    if (isset($user))
        $user = R::findOne('user', ' password = ? ', array(sha1($user->username . $pass . $user->email . $user->salt)));

    if (isset($user)) {
        start_session($user);

        $return['error'] = false;
        $return['page'] = "index.php";
    } else {
        $return['error'] = true;
        $return['msg'] = "<p>Utilizador e/ou palavra-passe inválidos.</p><p>Por favor rectifique os dados e tente de novo.</p>";
    }

    echo json_encode($return);
}

function logout()
{
    $session_uid = -1;
    $session_id = -1;

    if (isset($_SESSION['uid'])) {
        $session_uid = $_SESSION['uid'];
    }

    if (isset($_SESSION['sessionid'])) {
        $session_id = $_SESSION['sessionid'];
    }

    if ($session_uid > 0 && $session_id > 0) {
        $session = R::findLast('session', 'user_id = ? and sessionid = ?', array($session_uid, $session_id));

        session_destroy();
        R::trash($session);
    }

    $return['error'] = false;
    $return['page'] = 'index.php';

    echo json_encode($return);
}

function add_cache()
{
    R::begin();

    $cache = R::dispense('cache');

    try {
        $cache->code = !empty($_POST['data']['code']) ? trim($_POST['data']['code']) : null;
        $cache->name = !empty($_POST['data']['name']) ? trim($_POST['data']['name']) : null;
        $cache->place = !empty($_POST['data']['place']) ? trim($_POST['data']['place']) : null;
        $cache->latitude = !empty($_POST['data']['latitude']) ? trim($_POST['data']['latitude']) : null;
        $cache->longitude = !empty($_POST['data']['longitude']) ? trim($_POST['data']['longitude']) : null;
        $cache->observations = !empty($_POST['data']['observations']) ? trim($_POST['data']['observations']) : null;

        R::store($cache);
        R::commit();

        $return['error'] = false;
        $return['msg'] = "<p>A cache <a href='http://coord.info/" . $cache->code . "' target='_blank'> " . $cache->code . "</a> foi adicionada com sucesso.</p>";

    } catch (Exception $ex) {
        R::rollback();

        if (stristr($ex, "cannot be null")) {
            $errors = "<ul>";

            if (stristr($ex, "Column 'code'")) {
                $errors .= "<li>Código</li>";
            }

            if (stristr($ex, "Column 'name' cannot be null")) {
                $errors .= "<li>Nome</li>";
            }

            if (stristr($ex, "Column 'place' cannot be null")) {
                $errors .= "<li>Localidade</li>";
            }

            $errors .= "</ul>";

            $return['msg'] = "<p>Os seguintes campos não podem estar vazios:</p>" . $errors;
        }

        if (stristr($ex, "Duplicate entry") && stristr($ex, "key 'code'")) {
            $return['msg'] = "<p>A cache que está a tentar adicionar já existe!</p>";
        }

        if (empty($return['msg'])) {
            $return['msg'] = "<p'>Ocorreu um erro ao adicionar a cache.</p><p>Por favor verifique os dados introduzidos e tente de novo.</p>";
        }

        $return['error'] = true;
    }

    echo json_encode($return);
}

function edit_cache()
{
    R::begin();

    if (isset($_POST['data']['c'])) {
        $cache = R::load('cache', $_POST['data']['c']);

        try {
            $cache->code = isset($_POST['data']['code']) ? trim($_POST['data']['code']) : null;
            $cache->name = isset($_POST['data']['name']) ? trim($_POST['data']['name']) : null;
            $cache->place = isset($_POST['data']['place']) ? trim($_POST['data']['place']) : null;
            $cache->latitude = isset($_POST['data']['latitude']) ? trim($_POST['data']['latitude']) : null;
            $cache->longitude = isset($_POST['data']['longitude']) ? trim($_POST['data']['longitude']) : null;
            $cache->observations = isset($_POST['data']['observations']) ? trim($_POST['data']['observations']) : null;

            R::store($cache);
            R::commit();

            $return['error'] = false;
            $return['msg'] = "<p>A cache <a href='http://coord.info/" . $cache->code . "' target='_blank'> " . $cache->code . "</a> foi alterada com sucesso.</p>";

        } catch (Exception $ex) {
            R::rollback();

            if (stristr($ex, "cannot be null")) {
                $errors = "<ul>";

                if (stristr($ex, "Column 'code'")) {
                    $errors .= "<li>Código</li>";
                }

                if (stristr($ex, "Column 'name' cannot be null")) {
                    $errors .= "<li>Nome</li>";
                }

                if (stristr($ex, "Column 'place' cannot be null")) {
                    $errors .= "<li>Localidade</li>";
                }

                $errors .= "</ul>";

                $return['msg'] = "<p>Os seguintes campos não podem estar vazios:</p>" . $errors;
            }

            if (empty($return['msg'])) {
                $return['msg'] = "<p>Ocorreu um erro ao editar a cache.</p><p>Por favor verifique os dados introduzidos e tente de novo.</p>";
            }

            $return['error'] = true;
        }
    } else {
        $return['error'] = true;
        $return['msg'] = "<p>Não foi possível encontrar a cache seleccionada.</p>";
        $return['page'] = "browse.php";
    }

    echo json_encode($return);
}

function session_update()
{

}