<?php

header("Content-Type: application/json");



$dados =
json_decode(file_get_contents("php://input"), true);

$dietas = [

    "Perder peso" => [

        "simples" => "
        <h2>Dieta - Perder peso</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    2 a 3 ovos mexidos com aveia em flocos e 1 banana.
                </td>

                <td>
                    Cuscuz de milho com 1 ovo cozido e café preto.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                    150g de peito de frango grelhado, 4 colheres de arroz,
                    2 conchas de feijão e salada de repolho com cenoura.
                </td>

                <td>
                    150g de carne moída de segunda (acém),
                    purê de batata doce e salada de alface.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                    1 maçã ou laranja com 1 colher de pasta de amendoim.
                </td>

                <td>
                    Iogurte natural com aveia.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    Omelete (2 ovos) com espinafre ou couve,
                    acompanhado de mandioca cozida.
                </td>

                <td>
                    Sopa de legumes com frango desfiado.
                </td>
            </tr>            
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    <strong>A - Peito e Tríceps:</strong> Supino reto com barra, Supino inclinado com halteres, Crucifixo, Tríceps pulley, Tríceps francês.
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    <strong>B - Costas e Bíceps:</strong> Barra fixa (ou puxada alta), Remada curvada, Remada unilateral, Rosca direta, Rosca alternada.
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (mobilidade, alongamento) ou Cardio Leve
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                <strong>C - Pernas (Quadríceps e Panturrilhas):</strong> Agachamento livre, Leg press, Cadeira extensora, Avanço, Panturrilha em pé e sentado.
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    <strong>Ombros e pernas (Posterior e Gluteos):</strong> Desenvolvimento de ombros, Elevação lateral, Elevação frontal, Mesa flexora, Stiff, Elevação pélvica.
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Cardio Moderado ou Descanso
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>",

        "premium" => "
        <h2>Dieta - Perder peso</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    Iogurte grego proteico com frutas vermelhas (mirtilo, framboesa) e amêndoas laminadas.
                </td>

                <td>
                    Panqueca de Whey Protein Isolado com farinha de amêndoas e calda de frutas.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                    150g de filé de salmão assado, porção de quinoa e aspargos grelhados no azeite extra virgem.
                </td>

                <td>
                150g de filé mignon, arroz negro e mix de cogumelos (shimeji/shitake).  
                    
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                    Dose de Whey Protein Isolado batido com leite vegetal e meio avocado.
                </td>

                <td>
                    Mix de oleaginosas (castanha do pará, nozes, macadâmia) e 1 taça de kombucha.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    150g de tilápia fresca grelhada com purê de batata baroa (mandioquinha) e salada de folhas baby.
                </td>

                <td>
                    Carpaccio de carne com alcaparras, parmesão curado e salada de rúcula.
                </td>
            </tr>            
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    <strong>A - Peito e Tríceps:</strong> Supino reto com barra, Supino inclinado com halteres, Crucifixo, Tríceps pulley, Tríceps francês.
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    <strong>B - Costas e Bíceps:</strong> Barra fixa (ou puxada alta), Remada curvada, Remada unilateral, Rosca direta, Rosca alternada.
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (mobilidade, alongamento) ou Cardio Leve
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                <strong>C - Pernas (Quadríceps e Panturrilhas):</strong> Agachamento livre, Leg press, Cadeira extensora, Avanço, Panturrilha em pé e sentado.
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    <strong>Ombros e pernas (Posterior e Gluteos):</strong> Desenvolvimento de ombros, Elevação lateral, Elevação frontal, Mesa flexora, Stiff, Elevação pélvica.
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Cardio Moderado ou Descanso
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>"
    ],

    "Ganhar peso" => [

        "simples" => "
        <h2>Dieta - Ganhar peso</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    Mingau de aveia (1 xícara de aveia, 2 xícaras de leite integral) com 2 bananas e 2 colheres de sopa de pasta de amendoim.
                </td>

                <td>
                    Pão francês com 2 ovos mexidos e 1 copo de leite integral com achocolatado.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Manhã</strong></td>

                <td>
                    2 a 3 ovos mexidos com aveia em flocos e 1 banana.
                </td>

                <td>
                    Shake caseiro: 1 banana, 1 copo de leite integral, 2 colheres de sopa de aveia, 1 colher de sopa de pasta de amendoim.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                200g de frango (coxa/sobrecoxa), 6 colheres de arroz, 3 conchas de feijão, batata cozida e salada.
                </td>

                <td>
                    200g de carne moída (acém), macarrão com molho e lentilha.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                2 pães com ovos (3 ovos) e queijo.
                </td>

                <td>
                    Cuscuz de milho com carne seca desfiada e leite.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    200g de carne bovina (patinho/paleta), 6 colheres de arroz, purê de mandioca e legumes cozidos.
                </td>

                <td>
                    Sopa de legumes com bastante carne e macarrão.
                </td>
            </tr>
            
            <tr>
                <td><strong>Ceia</strong></td>

                <td>
                    1 copo de leite integral com 2 colheres de sopa de aveia e mel.
                </td>

                <td>
                    1 iogurte natural com granola.
                </td>
            </tr>
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    <strong>A - Peito e Tríceps:</strong> Supino reto com barra, Supino inclinado com halteres, Crucifixo, Tríceps pulley, Tríceps francês.
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    <strong>B - Costas e Bíceps:</strong> Barra fixa (ou puxada alta), Remada curvada, Remada unilateral, Rosca direta, Rosca alternada.
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (mobilidade, alongamento) ou Cardio Leve
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                <strong>C - Pernas (Quadríceps e Panturrilhas):</strong> Agachamento livre, Leg press, Cadeira extensora, Avanço, Panturrilha em pé e sentado.
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    <strong>Ombros e pernas (Posterior e Gluteos):</strong> Desenvolvimento de ombros, Elevação lateral, Elevação frontal, Mesa flexora, Stiff, Elevação pélvica.
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Cardio Moderado ou Descanso
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>",

        "premium" => "
        <h2>Dieta - Ganhar peso</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    Omelete (4 ovos orgânicos) com queijo cottage, abacate e 2 fatias de pão integral de fermentação natural.
                </td>

                <td>
                    Smoothie hipercalórico: Whey Protein Isolado, leite de amêndoas, banana, pasta de castanha de caju e tâmaras.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Manhã</strong></td>

                <td>
                    Iogurte grego proteico com mix de frutas vermelhas, granola artesanal e mel.
                </td>

                <td>
                    Shake caseiro: 1 banana, 1 copo de leite integral, 2 colheres de sopa de aveia, 1 colher de sopa de pasta de amendoim.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                250g de filé de salmão grelhado, quinoa real, batata baroa assada com alecrim e salada de folhas nobres com azeite extra virgem.
                </td>

                <td>
                    250g de filé mignon, risoto de arroz arbóreo com cogumelos e aspargos.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                Sanduíche de pão integral com pasta de amendoim integral, banana e mel.
                </td>

                <td>
                    Wrap de frango desfiado com cream cheese light, abacate e vegetais.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    250g de peito de frango orgânico, macarrão integral com molho pesto caseiro e brócolis no vapor.
                </td>

                <td>
                    250g de tilápia assada com purê de mandioquinha e legumes salteados no azeite.
                </td>
            </tr>
            
            <tr>
                <td><strong>Ceia</strong></td>

                <td>
                    Caseína com leite e oleaginosas (nozes, amêndoas).
                </td>

                <td>
                    Ovos cozidos (2 unidades) com azeite e sal rosa.
                </td>
            </tr>            
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    <strong>A - Peito e Tríceps:</strong> Supino reto com barra, Supino inclinado com halteres, Crucifixo, Tríceps pulley, Tríceps francês.
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    <strong>B - Costas e Bíceps:</strong> Barra fixa (ou puxada alta), Remada curvada, Remada unilateral, Rosca direta, Rosca alternada.
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (mobilidade, alongamento) ou Cardio Leve
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                <strong>C - Pernas (Quadríceps e Panturrilhas):</strong> Agachamento livre, Leg press, Cadeira extensora, Avanço, Panturrilha em pé e sentado.
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    <strong>Ombros e pernas (Posterior e Gluteos):</strong> Desenvolvimento de ombros, Elevação lateral, Elevação frontal, Mesa flexora, Stiff, Elevação pélvica.
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Cardio Moderado ou Descanso
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>"
    ],

    "Definir corpo" => [

        "simples" => "
        <h2>Dieta - Definir corpo</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    3 ovos mexidos, 2 fatias de pão integral, 1 fruta (banana ou maçã).
                </td>

                <td>
                    Mingau de aveia (1 xícara de aveia, água/leite desnatado) com 1 fruta.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Manhã</strong></td>

                <td>
                    1 iogurte natural desnatado com 1 colher de sopa de aveia.
                </td>

                <td>
                    1 fruta e 10 amendoins.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                150g de peito de frango grelhado, 4 colheres de sopa de arroz integral, 2 conchas de feijão, salada à vontade.
                </td>

                <td>
                    150g de carne moída refogada, 1 batata doce média assada, brócolis cozido.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                1 lata de sardinha em água, 2 torradas integrais.
                </td>

                <td>
                    Shake proteico caseiro (leite desnatado, 1 ovo cozido, banana).
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    Omelete (3 ovos) com vegetais (espinafre, tomate), salada verde.
                </td>

                <td>
                    150g de peito de frango desfiado, purê de abóbora.
                </td>
            </tr>
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    Musculação: Peito e Tríceps + 30 min Cardio
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    Musculação: Costas e Bíceps + 30 min Cardio
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (Caminhada leve) ou 45 min Cardio
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                    Musculação: Pernas e Ombros + 30 min Cardio
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    Musculação: Corpo Total (exercícios compostos) + 30 min Cardio
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    45 min Cardio (HIIT ou Moderado)
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>",

        "premium" => "
        <h2>Dieta - Definir corpo</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    Omelete (4 ovos orgânicos) com espinafre, abacate e 1 fatia de pão essênio.
                </td>

                <td>
                    Smoothie proteico (Whey Isolado, leite vegetal, frutas vermelhas, chia).
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Manhã</strong></td>

                <td>
                    Iogurte grego proteico com mix de oleaginosas e mirtilos.
                </td>

                <td>
                    Shake de Whey Hidrolisado com água de coco e 1 porção de frutas secas.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                180g de salmão grelhado, quinoa real, aspargos no vapor com azeite extra virgem.
                </td>

                <td>
                    180g de filé mignon, arroz negro, mix de cogumelos salteados.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                Wrap de frango desfiado com cream cheese light, folhas verdes e tomate cereja.
                </td>

                <td>
                    Shake de Whey Isolado pós-treino com banana e creatina.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    180g de tilápia assada, purê de batata baroa, salada de folhas baby com molho de limão.
                </td>

                <td>
                    Sopa detox de vegetais orgânicos com frango desfiado.
                </td>
            </tr>
            
            <tr>
                <td><strong>Ceia</strong></td>

                <td>
                    Caseína com leite vegetal e 10 amêndoas.
                </td>

                <td>
                Ovos cozidos (2 unidades) com azeite de oliva.
                </td>
            </tr>            
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    Musculação: Peito e Tríceps (com técnicas avançadas) + 20 min HIIT
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    Musculação: Costas e Bíceps (com técnicas avançadas) + 30 min Cardio Moderado
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Treino Funcional ou Natação + 30 min Cardio
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                    Musculação: Pernas e Ombros (com técnicas avançadas) + 20 min HIIT
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    Musculação: Corpo Total (foco em exercícios compostos) + 30 min Cardio Moderado
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Atividade Esportiva (tênis, beach tennis) ou 45 min Cardio
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Ativo (alongamento, yoga) ou Descanso Total
                </td>
            </tr>

        </table>"
    ],

    "Ganhar músculos" => [

        "simples" => "
        <h2>Dieta - Ganhar músculos</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    Mingau de aveia (1 xícara de aveia, 2 xícaras de leite integral) com 2 bananas e 2 colheres de sopa de pasta de amendoim.
                </td>

                <td>
                    4 ovos mexidos, 2 pães franceses com queijo e café com leite.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Manhã</strong></td>

                <td>
                    Shake caseiro: 1 banana, 1 copo de leite integral, 2 colheres de sopa de aveia, 1 colher de sopa de pasta de amendoim.
                </td>

                <td>
                    2 pães com frango desfiado e 1 fruta.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                200g de peito de frango, 6 colheres de sopa de arroz, 3 conchas de feijão, batata cozida e salada.
                </td>

                <td>
                    200g de carne moída, macarrão com molho, lentilha e legumes.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                2 pães com 3 ovos cozidos e queijo.
                </td>

                <td>
                    Cuscuz de milho com carne seca desfiada e leite.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    200g de carne bovina (patinho), 6 colheres de sopa de arroz, purê de mandioca e legumes cozidos.
                </td>

                <td>
                    Sopa de legumes com bastante carne e macarrão.
                </td>
            </tr>
            
            <tr>
                <td><strong>Ceia</strong></td>

                <td>
                    1 copo de leite integral com 2 colheres de sopa de aveia e mel.
                </td>

                <td>
                    iogurte natural com granola e 1 fruta.
                </td>
            </tr>            
        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    <strong>A - Peito, Tríceps e Ombros:</strong> Supino reto, Supino inclinado, Desenvolvimento de ombros, Tríceps testa, Elevação lateral.
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    <strong>B - Costas e Bíceps:</strong> Remada curvada, Puxada alta, Levantamento terra, Rosca direta, Rosca martelo.
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (Caminhada leve) ou Cardio Moderado
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                <strong>C - Pernas e Panturrilhas:</strong> Agachamento livre, Leg press, Cadeira extensora, Mesa flexora, Panturrilha em pé.
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    Repete Treino A ou B (alternar semanalmente)
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Cardio Moderado ou Descanso
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>",

        "premium" => "
        <h2>Dieta - Ganhar músculos</h2>

        <table class='tabela-dieta'>

            <tr>
                <th>Refeição</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
            </tr>

            <tr>
                <td><strong>Café da Manhã</strong></td>

                <td>
                    Omelete (4 ovos orgânicos) com espinafre, abacate e 2 fatias de pão de fermentação natural.
                </td>

                <td>
                    Smoothie hipercalórico: Whey Isolado, leite vegetal, banana, pasta de castanha de caju, tâmaras e aveia.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Manhã</strong></td>

                <td>
                    Iogurte grego proteico com mix de oleaginosas, mirtilos e granola artesanal.
                </td>

                <td>
                Shake de Whey Hidrolisado com água de coco e 1 porção de frutas secas.
                </td>
            </tr>

            <tr>
                <td><strong>Almoço</strong></td>

                <td>
                250g de salmão grelhado, quinoa real, aspargos no vapor com azeite extra virgem.
                </td>

                <td>
                    250g de filé mignon, arroz negro, mix de cogumelos salteados e batata baroa.
                </td>
            </tr>

            <tr>
                <td><strong>Lanche da Tarde</strong></td>

                <td>
                Sanduíche de pão integral com pasta de amendoim integral, banana e mel.
                </td>

                <td>
                    Wrap de frango desfiado com cream cheese light, abacate e vegetais.
                </td>
            </tr>

            <tr>
                <td><strong>Pós-Treino</strong></td>

                <td>
                Shake de Whey Isolado com maltodextrina/dextrose e creatina.
                </td>

                <td>
                    Sanduíche de pão integral com pasta de amendoim integral, banana e mel e shake caseiro: 1 banana, 1 copo de leite integral, 2 colheres de sopa de aveia, 1 colher de sopa de pasta de amendoim.
                </td>
            </tr>

            <tr>
                <td><strong>Jantar</strong></td>

                <td>
                    250g de peito de frango orgânico, macarrão integral com molho pesto caseiro e brócolis no vapor.
                </td>

                <td>
                    250g de tilápia assada com purê de mandioquinha e legumes salteados no azeite.
                </td>
            </tr>
            
            <tr>
                <td><strong>Ceia</strong></td>

                <td>
                    Caseína com leite vegetal e 10 amêndoas.
                </td>

                <td>
                    Ovos cozidos (2 unidades) com azeite de oliva e sal rosa.
                </td>
            </tr>   

        </table>
        
        <table class='tabela-treino'>

            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <tr>
                <td><strong>Segunda-feira</strong></td>

                <td>
                    <strong>A - Peito e Tríceps:</strong> Supino reto com barra, Supino inclinado com halteres, Crucifixo, Tríceps pulley, Tríceps francês.
                </td>
            </tr>

            <tr>
                <td><strong>Terça-feira</strong></td>

                <td>
                    <strong>B - Costas e Bíceps:</strong> Barra fixa (ou puxada alta), Remada curvada, Remada unilateral, Rosca direta, Rosca alternada.
                </td>
            </tr>

            <tr>
                <td><strong>Quarta-feira</strong></td>

                <td>
                    Descanso Ativo (mobilidade, alongamento) ou Cardio Leve
                </td>
            </tr>

            <tr>
                <td><strong>Quinta-feira</strong></td>

                <td>
                <strong>C - Pernas (Quadríceps e Panturrilhas):</strong> Agachamento livre, Leg press, Cadeira extensora, Avanço, Panturrilha em pé e sentado.
                </td>
            </tr>

            <tr>
                <td><strong>Sexta-feira</strong></td>

                <td>
                    <strong>Ombros e pernas (Posterior e Gluteos):</strong> Desenvolvimento de ombros, Elevação lateral, Elevação frontal, Mesa flexora, Stiff, Elevação pélvica.
                </td>
            </tr>
            
            <tr>
                <td><strong>Sabado</strong></td>

                <td>
                    Cardio Moderado ou Descanso
                </td>
            </tr>
            
            <tr>
                <td><strong>Domingo</strong></td>

                <td>
                    Descanso Total
                </td>
            </tr>

        </table>"
    ]
];