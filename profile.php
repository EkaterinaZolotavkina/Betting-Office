<?php
require 'header.php'
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
						<div id="box2">
							<h3>
								<?php
								$sql = "SELECT * FROM Client
								WHERE client_id =" . $_GET['id'] . ';';
								$stmt = $db->prepare($sql);
								$stmt->execute();
								$res = $stmt->fetch(PDO::FETCH_ASSOC);
								echo $res['fio'];
								?>
							</h3>
							<ul class="imageList">
							<?php
   							echo '
	   							<li>
									<p> Денег на счету:  ' . $res['cash'] . 
									'</p>' .
								'</li>';
							?>
							</ul>
							<h3>Ваши ставки</h3>
							<ul class = "imageList">
								<?php
								$sql = "SELECT b.value, b.date, e.event_id, b.winning, t1.name ft, t2.name st, e.result, b.prediction FROM Bets b
								INNER JOIN Events e ON b.event_id = e.event_id
								INNER JOIN Teams t1 ON e.team_id = t1.team_id
								INNER JOIN Teams t2 ON e.second_team_id = t2.team_id
								WHERE client_id = " . $_GET['id'] . "
								ORDER BY b.date;";
								$increment = 1;
								foreach ($db->query($sql) as $row) {
	   								$on = "";
	   								switch ($row['prediction']) {
	   									case '1':
	   										$on = $row['ft'];
	   										break;
	   									case '2':
	   										$on = "ничью";
	   										break;
	   									case '3':
	   										$on = $row['st'];
	   										break;
	   								}
	   								echo '
			   							<li>
											<p>'.$increment . '. ' . $row['value'] . ' на   ' . $on . 
											'    в матче  <a href = "event.php?id=' . $row['event_id'] . '">' . $row['ft'] .
											'  -  ' . $row['st'] . '</a></p>
										</li>';
										$increment++;
        						}
        						?>
							</ul>
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php require 'footer.php';