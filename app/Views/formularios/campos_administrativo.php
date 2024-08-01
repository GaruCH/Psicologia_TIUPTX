<div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-control-label">Número de Trabajador: (<font color="red">*</font>)</label>
                    <div class="form-floating mb-3">
                        <?php
                        $parametros = array(
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'numero_trabajador',
                            'name' => 'numero_trabajador',
                            'placeholder' => 'Número de Trabajador',
                            'style' => 'background-color: #CC9933; color: #FFFFFF;');
                        echo form_input($parametros);
                        ?>
                        <div class="invalid-feedback"></div>
                        <label for="numero_trabajador" style="color: #FFFFFF;">
                        <i data-feather="user" class="feather-sm text-white fill-white me-2"></i>Número de Trabajador
                        </label>
                    </div>
                </div>
            <div class="col-md-6 mb-3">
                <label class="form-control-label">Área: (<font color="red">*</font>)</label>
                <div class="form-floating mb-3">
                    <?php
                    $parametros = [
                        'class' => 'form-select',
                        'id' => 'area',
                        'style' => 'background-color: #CC9933; color: #FFFFFF;'
                    ];
                    echo form_dropdown('area', $areas, '', $parametros);
                    ?>
                    <div class="invalid-feedback"></div>
                    <label for="area" style="color: #FFFFFF;">
                        <i class="fas fa-lg fa-briefcase text-white fill-white me-2"></i>Área
                    </label>
                </div>
            </div>
        </div>