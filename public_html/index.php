<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class bee {

    var $hitpoints;
    var $type;

    function getHp() {
        return $this->hitpoints;
    }

}

class queen extends bee {

    public $type = 'queen';

    function __construct() {

        $this->hitpoints = 100;

    }

    function hitTheBee() {

        $this->hitpoints = $this->hitpoints-8;

    }
}

class worker extends bee {

    public $type = 'worker';

    function __construct() {
        $this->hitpoints = 75;
    }

    function hitTheBee() {
        $this->hitpoints = $this->hitpoints - 10;
    }

}

class drone extends bee {

    public $type = 'drone';

    function __construct() {
        $this->hitpoints = 50;
    }

    function hitTheBee() {
        $this->hitpoints = $this->hitpoints - 12;
    }

}

function hitTheBee() {

    $bees = $_SESSION['bees'];

    if (!$bees) {

        echo "COMPLETED WITH <b>" . $_SESSION['hits'] . "</b> HITS";
        echo '<hr/><a href="/?submit=start">RESTART</a>';
        exit();

    }

    $key = array_rand($bees, 1);

    $hitbee = $bees[$key];

    $hitbee->hitTheBee();

    if ($bees[$key]->getHp() <= 0) {
        unset($bees[$key]);
    }

    foreach($bees as $value) {
        echo $value->type . ": " . $value->getHp() . " HP<br/>";
    }

    if (isset($_SESSION['hits'])) {
        echo 'Hits: ' . $_SESSION['hits'];
    }

    if ($bees) {
        echo '<hr/><a href="/?submit=start">RESTART</a>';
    }

    $_SESSION['bees'] = $bees;

}
?>

<?php if ($_SESSION['bees']) { ?>
    <form method="GET">
        <input type="submit" value="hit-the-bee" name="submit">
    </form>
<?php } ?>

<?php

if (isset($_GET['submit']) && $_GET['submit'] == 'hit-the-bee') {

    if ($_SESSION['bees']) {
        $_SESSION['hits'] += 1;
    }

    hitTheBee();

} elseif (isset($_GET['submit']) && $_GET['submit'] == 'start') {

    $_SESSION['bees'] = array(
        new queen(),
        new worker(),
        new worker(),
        new worker(),
        new worker(),
        new worker(),
        new drone(),
        new drone(),
        new drone(),
        new drone(),
        new drone(),
        new drone(),
        new drone(),
        new drone(),
        new drone()
    );

    $_SESSION['hits'] = 0;

    header('location: /');

} else {

    $bees = $_SESSION['bees'];

    foreach ($bees as $value) {
        echo $value->type . ": " . $value->getHp() . " HP<br/>";
    }

    if ($_SESSION['hits'] > 0) {
        echo 'Hits: ' . $_SESSION['hits'];
    }

}

?>