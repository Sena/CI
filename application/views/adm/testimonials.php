            <div class="new-record">
                  <a href="./<?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/novo" />
                        Novo
                  </a>
            </div>
            <table class="dataTable">
                  <thead>
                        <tr>
                              <th>Nome</th>
                              <th style="width:37px"></th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php foreach ($list->result() as $row) :?>
                        <tr>
                              <td><?php echo $row->name; ?></td>
                              <td>
                                    <a href="./<?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/editar/<?php echo $row->id; ?>">
                                          <img src="./assets/<?php echo $this->uri->segment(1); ?>/img/edit.png" />
                                    </a>
                                    <a href="./<?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/delete/<?php echo $row->id; ?>">
                                          <img src="./assets/<?php echo $this->uri->segment(1); ?>/img/delete.png" />
                                    </a>
                              </td>
                        </tr>
                        <?php endForeach;?>
                  </tbody>
            </table>