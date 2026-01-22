<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'price',
        'price_period',
        'image_path',
        'highlights',
        'order',
        'featured',
        'status',
        'cta_text',
        'cta_url',
    ];

    /**
     * Os atributos que devem ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'order' => 'integer',
    ];

    /**
     * Escopo para filtrar apenas serviços publicados
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Escopo para filtrar apenas serviços em destaque
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Obter array de destaques a partir do JSON
     *
     * @return array
     */
    public function getHighlightsArrayAttribute()
    {
        return $this->highlights ? json_decode($this->highlights, true) : [];
    }

    /**
     * Formatar o preço com o período
     *
     * @return string|null
     */
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return null;
        }

        $formattedPrice = number_format($this->price, 2);
        
        if ($this->price_period) {
            return $formattedPrice . ' / ' . $this->price_period;
        }
        
        return $formattedPrice;
    }
}
