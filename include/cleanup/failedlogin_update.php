<?php
/**
 *   https://github.com/Bigjoos/
 *   Licence Info: GPL
 *   Copyright (C) 2010 U-232 v.3
 *   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.
 *   Project Leaders: Mindless, putyn.
 *
 */
function docleanup($data)
{
    global $INSTALLER09, $queries, $mc1;
    set_time_limit(0);
    ignore_user_abort(1);
    //== Failed logins
    $secs = 1 * 86400; // Delete failed login attempts per one day.
    $dt = (TIME_NOW - $secs); // calculate date.
    sql_query("DELETE FROM failedlogins WHERE banned='no' AND added < $dt") or sqlerr(__FILE__, __LINE__);
    if ($queries > 0) write_log("Expired failed login clean-------------------- Expired failed logins cleanup Complete using $queries queries --------------------");
    if (false !== mysqli_affected_rows($GLOBALS["___mysqli_ston"])) {
        $data['clean_desc'] = mysqli_affected_rows($GLOBALS["___mysqli_ston"])." items deleted/updated";
    }
    if ($data['clean_log']) {
        cleanup_log($data);
    }
}
function cleanup_log($data)
{
    $text = sqlesc($data['clean_title']);
    $added = TIME_NOW;
    $ip = sqlesc($_SERVER['REMOTE_ADDR']);
    $desc = sqlesc($data['clean_desc']);
    sql_query("INSERT INTO cleanup_log (clog_event, clog_time, clog_ip, clog_desc) VALUES ($text, $added, $ip, {$desc})") or sqlerr(__FILE__, __LINE__);
}
?>
