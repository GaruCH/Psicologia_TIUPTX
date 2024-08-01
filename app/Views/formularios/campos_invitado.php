<div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-control-label">Identificador: (<font color="red">*</font>)</label>
                <div class="form-floating mb-3">
                    <?php
                    $parametros = array(
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'identificador',
                        'name' => 'identificador',
                        'placeholder' => 'Identificador',
                        'style' => 'background-color: #CC9933; color: #FFFFFF;'
                    );
                    echo form_input($parametros);
                    ?>
                    <div class="invalid-feedback"></div>
                    <label for="identificador" style="color: #FFFFFF;"><i data-feather="user" class="feather-sm text-white fill-white me-2"></i>Identificador</label>
                </div>
            </div>
        </div>