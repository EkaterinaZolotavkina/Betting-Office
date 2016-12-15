<?php
require_once 'db.php';
require 'header.php';
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
							<h2>
								Матч дня
							</h2>
							<p>
								<?php
								$sql = 'SELECT e.event_id, e.team_id, e.second_team_id, date, t.name first_team, t2.name second_team FROM Events e
								INNER JOIN Teams t ON e.team_id = t.team_id
								INNER JOIN Teams t2 ON e.second_team_id = t2.team_id
								WHERE match_of_the_day = TRUE and date::date = current_date and t.type_id =' . $_GET['id'] . '
								ORDER BY date;';

								$stmt = $db->prepare($sql);
								$stmt->execute();
								$res = $stmt->fetch(PDO::FETCH_ASSOC);

								echo '<img class="left" src="images/teams/' . $res['team_id'] . '.png" width="170" height="170" alt="" />';							
								echo '<span class="teams"><a href= event.php?id=' . $res['event_id'] . '>' . $res['first_team'] . ' — ' . $res['second_team'] . '</a></span>';
								echo '<img class="right" src="images/teams/' . $res['second_team_id'] . '.png" width="170" height="170" alt="" />';
								echo '<br>' . $res['date'];
								?>
							</p>

						</div>
						<div id="box2">
							<h3>
								Матчи
							</h3>
							<ul class="imageList">
							<?php
							$sql = "SELECT e.event_id id, date, t.name first_team, t.type_id t_id, t2.name second_team FROM Events e
							INNER JOIN Teams t ON e.team_id = t.team_id
							INNER JOIN Teams t2 ON e.second_team_id = t2.team_id
							WHERE t.type_id =" . $_GET['id'] . "AND 
							date::date BETWEEN current_date AND current_date + INTEGER '2'
							ORDER BY date;";
							
							foreach ($db->query($sql) as $row) {
   							echo '
	   							<li>
									<a href = event.php?id=' . $row['id'] . '><img class="left" src="images/sporttype/' . $row['t_id'] . '.png" width="64" height="64" alt="" />
									<p>' . $row['first_team'] . ' — ' . $row['second_team'] . "<br><br>" . 
									'</p></a>' . $row['date'] .
								'</li>';
        					}
							?>
							</ul>
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php require 'footer.php';