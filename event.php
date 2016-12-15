<?php
require('header.php');
require_once('db.php');

function calc_coeffs($value)
{
	$c1 = $c2 = $c3 = 0;
	if($value < 0.3){
		$c1 = $value / 1.7;
		$c2 = $value / 1.8;
		$c3 = 1 - $c1 - $c2;
	}
	elseif ($value > 0.7) {
		$c3 = $value / 1.7;
		$c2 = $value / 1.8;
		$c1 = 1 - $c3 - $c2;
	}
	else {
		$c1 = $value/1.8;
		$c3 = (1 - $c1/1.7) / 1.8;
		$c2 = 1 - $c1 - $c3;
	}
	$array = array(number_format((float)1 / $c1 * 0.92, 2) , number_format((float) 1 / $c2 * 0.92, 2) ,
	 number_format((float) 1 / $c3 * 0.92, 2) );

	return $array;
}

if(isset($_POST['btn-bet'])){
	$value = $_POST['value'];
	$prediction = $_POST['select_prediction'];
	$sql = 'INSERT INTO Bets (value, date, client_id, event_id, winning, prediction) VALUES
	(' . $value . ', current_timestamp,' . $_SESSION['user'] . ',' . $_GET['id'] . ', NULL,' . $prediction . ');';
	$stmt = $db->prepare($sql);
	if($stmt->execute())
	{
		echo '<script>alert("Cтавка принята");</script>';
	}
	else {
		echo '<script>alert("Недостаточно денег на счёте");</script>';
	};
}

if(isset($_POST['btn-post_comment'])){
	$text = $_POST['comment_text'];
	$sql = "INSERT INTO Comments (text, date, client_id, event_id) VALUES
	('" . $text . "', current_timestamp," . $_SESSION['user'] . ',' .  $_GET['id'] . ');';
	$stmt = $db->prepare($sql);
	$stmt->execute();
}
?>
			<div id="main">
					<div id="sidebar1">
						<h3>
							Виды спорта
						</h3>
						<ul class="linkedList">
						<?php
						$sql = "SELECT * FROM Sporttype";

   						foreach ($db->query($sql) as $row) {
   							echo '
   							<li>
								<a href="games.php?id=' . $row['type_id'] . '">' . $row['name'] . '</a>
							</li>';
        				}
        				?>
						</ul>
						
					</div>
					<div id="content">
						<div id="box1">
						<?php
						$sql = 'SELECT e.event_id, e.result, e.team_id, e.second_team_id, date, t.name first_team, t2.name second_team , e.probability_first FROM Events e
						INNER JOIN Teams t ON e.team_id = t.team_id
						INNER JOIN Teams t2 ON e.second_team_id = t2.team_id
						WHERE event_id =' . $_GET['id'] . ';';

						$stmt = $db->prepare($sql);
						$stmt->execute();
						$res = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
							<p>
								<?php
								echo '<img class="left" src="images/teams/' . $res['team_id'] . '.png" width="170" height="170" alt="" />';
								$result = calc_coeffs($res['probability_first']);							
								echo '<span class="teams">' . $res['first_team'] . ' — ' . $res['second_team'] . '</span>';
								echo '<img class="right" src="images/teams/' . $res['second_team_id'] . '.png" width="170" height="170" alt="" />';
								echo '<br>' . $res['date'];
								echo '<br><br><span class="status">Статус матча : ';
								if(is_null($res['result'])) 
									echo 'Матч не начался';
								else 
									echo 'Матч завершился со счетом ' . $res['result'];
								?>
								</span>
							</p>
						</div>
						<div>
						<?php
						if(isset($_SESSION['user']))
						{
						if(is_null($res['result']))
						{

						?>
						<h1 class="hbet">Ставка</h1>
							<div id="bet">   
			          			<form action="" method="post">
				          			<!-- <div class="field-wrap"> -->
				          				<span class="css3-selectbox"><select name="select_prediction">
				          					<option value="1">
				          						<?php echo 'Победит ' . $res['first_team']; ?>
				          					</option>
				          					<option value="2">
				          						Ничья
				          					</option>
				          					<option value="3">
				          						<?php echo 'Победит ' . $res['second_team']; ?>
				          					</option>
				          				</select></span>
				          				<br>
				            			<input type="text" name="value" required autocomplete="off" placeholder="Величина ставки"/><br>
				          			<!-- </div> -->
				          			<button type="submit" name="btn-bet" class="button button-block bet"/>Сделать ставку</button>
				          		</form>
				          	</div>
				          	<div id="coeffs">
				          	<?php
								echo '<table>
									<tr>
										<td>П1</td>
										<td>Н</td>
										<td>П2</td>
									</tr>
									<tr class="c">
										<td>' . $result[0] . '</td><td>' . $result[1] . '</td><td>' . $result[2] . '</td>
									</tr>
								</table>';
								?>
							</div>
				          	<?php
				          }
				      	}
				        ?>
				          	
						</div>
						<div id="box2" class="comments">
							<h3>
								Комментарии
							</h3>
							<ul class="imageList">
							<?php
							$sql = "SELECT com.text, date_trunc('second', com.date) d_t, cl.login FROM Comments com
							INNER JOIN Client cl ON cl.client_id = com.client_id
							WHERE event_id = " . $_GET['id'] . 
							'ORDER BY date;';
							foreach ($db->query($sql) as $row) {
   							echo '
	   							<li>
	   							<img class="left" src="images/pic2.jpg" width="64" height="64" alt="" />
									<p>' . $row['login'] . '    ' . $row['d_t'] . 
									'<br>' . $row['text'] .
									'</p>
								</li>';
        					}
							?>
							</ul>
							<?php
							if(isset($_SESSION['user']))
							{
							?>
							<div id="post_comment">   
			          			<form action="" method="post">
				            		<textarea cols=65 rows = 3 name="comment_text" required autocomplete="off" placeholder="Введите комментарий"/></textarea>
				            		<br>
				          			<button type="submit" name="btn-post_comment" class="button button-block bet"/>Отправить комментарий</button>
				          		</form>
							</div>
							<?php
							}
							?>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>

<?php require 'footer.php';