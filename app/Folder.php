<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'folders';

    protected $fillable = [
        'name',
        'piece',
        'status',
        'dateArrive',
        'dateScan',
        'dateSaisi',
        'dateIntegration',
        'achat',
        'vente',
        'facture',
        'banque',
        'divers',
        'user_id',
        'client_id'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $piece;

    /**
     * @ORM\Column(type="integer")
     */
    private $achat;

    /**
     * @ORM\Column(type="integer")
     */
    private $vente;

    /**
     * @ORM\Column(type="integer")
     */
    private $facture;

    /**
     * @ORM\Column(type="integer")
     */
    private $divers;

    /**
     * @ORM\Column(type="integer")
     */
    private $banque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numFolder;

    /**
     * @ORM\Column(type="date", length=255)
     */
    private $dateArrive;

    /**
     * @ORM\Column(type="date", length=255)
     */
    private $dateScan;

    /**
     * @ORM\Column(type="date", length=255)
     */
    private $dateSaisi;

    /**
     * @ORM\Column(type="date", length=255)
     */
    private $dateIntegration;
}
