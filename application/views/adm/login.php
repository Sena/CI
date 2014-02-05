		<form action="./<?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/auth" method="post">
		  <fieldset>
		    <legend> Autenticação </legend>
		    <input type="text" name="username" id="username" placeholder="Usuário">
		   	<input type="password" id="password" name="password" placeholder="Senha">
		   	<input type="submit" value="Entrar" />
		  </fieldset>
		</form>