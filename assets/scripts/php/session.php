<?php

require_once('init.php');

function start_session($user)
{
    clean_expired_sessions($user);

    $session = R::dispense('session');

    $session->datetime = date('c');
    $session->user = $user;
    $session->timeout = 300;
    $session->sessionid = time() ^ rand();

    R::store($session);

    session_regenerate_id();

    $_SESSION['uid'] = $session->user->id;
    $_SESSION['sessionid'] = $session->sessionid;
    $_SESSION['username'] = $username = $session->user->username;
}

function clean_expired_sessions($user)
{
    $sessions = R::find('session', 'user_id = ?', array($user->id));

    foreach ($sessions as $session) {
        R::trash($session);
    }
}

function session_is_valid()
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

        if (isset($session) && $session->sessionid == $session_id) {
            if ((strtotime($session->datetime) + $session->timeout) - time() > 0) {
                $session->datetime = date('c');
                R::store($session);

                return true;
            } else {
                session_destroy();
                R::trash($session);
            }
        }
    }

    return false;
}

function get_username()
{
    return session_is_valid() && isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

function is_admin()
{
    return get_username() != null && get_username() == 'admin';
}