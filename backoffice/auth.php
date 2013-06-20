<?php
if (!$user instanceof User) {
    header('Location: dommage.html');
    exit;
}