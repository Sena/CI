		<h1><?php echo isset($data->id) ? 'Editar' : 'Novo' ?> Depoimento</h1>
		<form action="./<?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/record/<?php echo isset($data->id) ? $data->id : NULL ?>" method="post" enctype="multipart/form-data" class="form">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <label for="name">Nome</label>
                        </td>
                        <td>
                            <input type="text" name="name" id="name" value="<?php echo isset($data->name) ? $data->name : NULL ?>" /><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="date">Data</label>
                        </td>
                        <td>
                            <input type="text" name="date" id="date" value="<?php echo isset($data->date) && $data->date != '00/00/0000' ? $data->date : date('d-m-Y') ?>" data-validation="date" data-validation-format="dd/mm/yyyy" /><br />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <label for="src">Imagem</label>
                        </td>
                        <td>
                            <input type="file" id="src" name="src" /><br />
                            <?php if(isset($data->src)): ?>
                            <label for="src"><img src="<?php echo $data->src ?>" /></label>
                            <?php endif ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Salvar" /></td>
                    </tr>
                </tbody>
            </table>
		</form> 