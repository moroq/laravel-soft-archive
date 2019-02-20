<?php

namespace FelipeDeCampos\LaravelSoftArchive\Test\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftArchives;

class ArchivedModel extends Model
{
    use SoftArchives;
}
