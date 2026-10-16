<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexCharts;

class CursoChart
{
    public function build(): \AlielMejiaDev\LarapexCharts\PieChart
    {
        $cursos = Cursos:: all();

        $qtdTurmas = [];
        $nomeCursos = [];

        foreach ($cursos as $item){
            $nomeCursos[] = $item->nome;
            $qtdTurmas[] = $item->turmas->count();
        }

        return (new LarapexCharts) ->pieCharts()
            ->setTitle('Cursos Disponíveis')
            ->setSubitle('Semestre 2026.2')
            ->addData($qtdTurmas)
            ->setLabels($nomeCurso)

    }

}
