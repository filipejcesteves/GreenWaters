<?php

require_once('assets/scripts/php/utils.php');

//create_user('username', 'email', 'pass');
create_user('tiago', 'costa.tiago@gmail.com', 'tiago');
create_user('filipe', 'filipe.jc.esteves@gmail.com', 'filipe');
create_user('admin', null, 'admin');

$user = R::findOne('user', 'username = ?', array('filipe'));

create_data_row('$12023|130101152630|1237|????@', $user);
create_data_row('$11021|130101162530|0136|????@', $user);
create_data_row('$12031|130101172332|0139|????@', $user);
create_data_row('$11032|130101182439|0130|????@', $user);
create_data_row('$12011|130101192437|0131|????@', $user);
create_data_row('$11011|130101202436|0132|????@', $user);
create_data_row('$12021|130101212435|0133|????@', $user);
create_data_row('$11020|130101222434|0136|????@', $user);
create_data_row('$12031|130101232431|0237|????@', $user);
create_data_row('$11033|130101122432|0539|????@', $user);

?>