<br><hr>
		<form action="/order.php" method="post" id="order">
			<h3>Заказать книгу</h3>
			Домашний адресс <input type="text" name="addr"><br>
			Ф.И.О.<input type="text" name="name"><br>
			количество	<input type="number" min="1" max="50" name="cnt"><br>
			<input type="submit" value="Заказать" name="sub">
		</form>
				<style>
			header{border: 1px grey solid;}
			body{margin:0 auto;width: 928px;}
			article{width: 200px;overflow: hidden;height: 350px;display: inline-block;border: 1px grey solid;margin: 10px;border-radius: 5px;padding: 5px;}
			article h2{font-size: 15px;margin-top: 1px;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;}
			article h3{font-size: 12px;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;}
			article button{position: relative;top: -20px;}
			article span{float: right;}
			article img{position: relative;top: -14px;display: block;width: 200px;}
			img{float: right;}
		</style>