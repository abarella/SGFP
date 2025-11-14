<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formRendProd' id='formRendProd'>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-12 text-bold text-center text-black py-2">
                            Rendimento da Produção
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Atividade inicial</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor1'>1</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Atividade final produzida</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor2'>2</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Cálculo de rendimento em porcentagem<br>
                            Ativ. final produzida / atv inicial x 100 >= 80%
                            </label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor1'>999 %</label>
                        </div>
                    </div>
                    <br>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formReconMat' id='formReconMat'>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-12 text-bold text-center text-black py-2">
                            Reconciliação
                        </div>
                    </div>
                    <br>

                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Atividade final produzida</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor1'>1</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Atividade distribuída</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor2'>2</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Atividade de concentrado</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor3'>3</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Atividade da sobra</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor4'>4</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>Cálculo de rendimento em porcentagem<br>
                            Ativ. Distrivuida + Atividade de concentrado + Atividade da sobra / atv final produzida x 100 >= 95%
                            </label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor1'>999 %</label>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

