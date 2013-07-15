{include file="./header.tpl"}
<div class="row-fluid">
	<div class="well span4"> 
		<form name="pick_table" method="get">
			<fieldset>
				<legend>Seleccione la tabla</legend>
				<table class="table">
					<tr>
						<th>Tabla</th>
						<td>
							<select name="table">
								{foreach from=$tables key=name item=contenido}
								<option value="{$name}" {if $name==$_get.table}selected="selected"{/if}>{$contenido.description}</option>
								{/foreach}
							</select>
						</td>
						<td><input type="submit" class="btn" value="Editar" /></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	{if $table}
	<div class="hero-unit">
		<form name="table_editor" method="post">
			<strong>Descripción:</strong><input name="description" value="{$table.description}" />
			<label class="label btn"><input type="checkbox" name="display" value="1" {if $table.display}checked="checked"{/if} />Mostrar en el menú</label>
			<table class="table table-bordered table-striped table-hover">
				<tr>
					<th>Campo</th>
					<th>Nombre de Campo</th>
					<th>Tipo de Campo</th>
					<th>Mostrar en las tablas</th>
					<th>Opciones</th>
				</tr>
				{if (is_array($table.elements))} {foreach from=$table.elements key=field item=element} 
				<tr>
					<th>{$field}</th>
					<td><input name="{$field}[description]" value="{$element.description}" /></td>
					<td>
						<select name="{$field}[type]">
							{foreach from=$types key=type item=description}
							<option value="{$type}" {if $type==$element.type}selected="selected"{/if}>{$description}</option>	
							{/foreach}
						</select>
					</td>
					<td>
						<input type="checkbox" name="{$field}[display]" {if $element.display}checked="checked"{/if} />
						Mostrar.
					</td>
					<td>
						<strong>Requerido: </strong>
						<select name="{$field}[options][required]">
							<option value="">No</option>
							<option value="1" {if $element.options.required}selected="selected"{/if}>Sí</option>
						</select>
						{assign var=relation value=$element.options.relation}
						{if $relation}
						<strong>Relación:</strong><br>
						Tabla:
						<select name="{$field}[options][relation][table]">
							{foreach from=$tables key=name item=contenido}
							<option value="{$name}" {if $name==$relation.table}selected="selected"{/if}>{ucfirst($name)}</option>
							{/foreach}
						</select><br>
						Clave foránea:
						<input name="{$field}[options][relation][value_field]" value="{$relation.value_field}"/><br>
						Campo para mostrar:
						<input name="{$field}[options][relation][display_field]" value="{$relation.display_field}"/>
						{/if}
					</td>
				</tr>	
				{/foreach} {/if}
				<tr>
					<th colspan="5"><input type="submit" class="btn" name="save" value="Guardar Cambios"/></th>
				</tr>
			</table>
		</form>
	</div>
	{/if}
</div>
{include file="./footer.tpl"}