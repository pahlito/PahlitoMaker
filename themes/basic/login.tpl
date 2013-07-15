{include file="./header.tpl"}
	<form id="login_form" method="post">
		<table class="center">
			<thead>
				<tr>
					<th colspan="2">Bienvenido</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>
						<label for="email">Email</label>
					</th>
					<td>
						<input id="email" name="email" type="text" value="{$email}" />
					</td>
				</tr>
				<tr>
					<th>
						<label for="pass">Password</label>
					</th>
					<td>
						<input id="pass" name="pass" type="password" />
					</td>
				</tr>
				<tr>
					<td colspan="2" class="error">{$error}</td>
				</tr>
				<tfoot>
					<th colspan="2">
						<input id="submit" type="submit" value="Ingresar">
					</th>
				</tfoot>
			</tbody>
		</table>
	</form>
{include file="./footer.tpl"}
