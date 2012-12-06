<?

$hostname = 'mysql.thedox.z8.ru';
$username = 'dbu_thedox_9';
$password = '69sl3ar0TNW';
 
$db = mysql_connect($hostname, $username, $password)
        or die('connect to database failed');
 
mysql_set_charset('utf8');
 
mysql_select_db('db_thedox_18')
        or die('db not found');
$query = 'SELECT rank.name FROM rank
                        INNER JOIN userRank_2 as userRank
                            ON rank.rankID=userRank.rankID
                        INNER JOIN user_2 as user
                            ON userRank.userID=user.userID
                      WHERE user.login="Ikarius";';
$result = mysql_query($query)
        or trigger_error(mysql_errno() . ' ' . 
            mysql_error() . ' query: ' . $sql);
$res = mysql_fetch_assoc($result);			
echo $res['name'];
echo '<hr/>';

try
{
    $mysql = new PDO( 'mysql:host=' . 'mysql.thedox.z8.ru' .
            ';port='      .  3306 .
            ';dbname='    . 'db_thedox_18',
        'dbu_thedox_9',
        '69sl3ar0TNW',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $mysql->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
}
catch(Exception $e)
{
    echo 'Error : '.$e->getMessage().'<br />';
    echo 'N°: '.$e->getCode();
}

$query = 'SELECT rank.name FROM rank
                        INNER JOIN userRank_2 as userRank
                            ON rank.rankID=userRank.rankID
                        INNER JOIN user_2 as user
                            ON userRank.userID=user.userID
                      WHERE user.login="Ikarius";';
foreach ($mysql->query($query) as $row) $rank = $row['name'];

echo $rank;
?>
