<?php
session_start();
echo isset($_SESSION['customer_id']) ? '1' : '0';
