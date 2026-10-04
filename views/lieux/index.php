<?php

foreach ($lieux as $lieu) {
    echo '<p>' . htmlspecialchars($lieu->getLieuNom()) . '</p>';
    echo '<p>' . htmlspecialchars($lieu->getLieuAdresse()) . '</p>';
}