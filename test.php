<html>
<head>
    <title>Online PHP Script Execution</title>
</head>
<body>
<?php
echo "<h1>Hello, PHP!</h1>";
?>
<?php
// Coercive mode
function sum(int ...$ints) {
    return array_sum($ints);
}
echo (sum(2, '3', 4.1));
?>
</body>
</html>