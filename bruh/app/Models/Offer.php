<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JetBrains\PhpStorm\ArrayShape;

class Offer extends Model
{
    use HasFactory, Searchable;

    /**
     * @var string database table name
     */
    protected $table = 'offers';


    /* TODO: It should be called `Situation' or mb. situation is a subgroup for a case */
    /**
     * @var array all possible issue cases
     *  NOTE: better to store cases like that (at least for now) as it is faster and better than SQL enums or creating another separate table,
     *          and the number of cases is not that high.
     */
    public const CASES = [
        1 => 'vehicle',
        2 => 'health',
        3 => 'income protection',
        4 => 'casualty',
        5 => 'life',
        6 => 'property',
        7 => 'credit',
    ];

    /**
     * Get case id by case name.
     *
     * @param string $case case name
     * @return int case id
     */
    public static function caseId(string $case): int
    {
        return array_search($case, self::CASES);
    }

    /**
     * Get case name by provided case id.
     *
     * @param int $caseId case id
     * @return string case name/value
     */
    public static function caseNameById(int $caseId): string
    {
        return self::CASES[$caseId];
    }

    /**
     * Get case name by case id.
     *
     * @return string case name/value
     */
    public function caseName(): string
    {
        return self::CASES[$this->attributes['case_id']];
    }

    /**
     * Get offer's insurer.
     *
     * @return BelongsTo insurer
     */
    public function insurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class, 'insurer_id', 'id');
    }

    /**
     * Get company name that published this offer.
     * TODO: Optimization notes: Many multi selects --> JOIN-ing selection will be faster.
     *
     * @return string company name
     */
    public function companyName(): string
    {
        return $this->insurer()->get()->first()->company_name;
    }

    public function requests(): HasMany
    {
        return $this->hasMany(OfferRequest::class);
    }

    /**
     * Convert model to an array.
     * Necessary for elasticsearch match.
     *
     * @return array
     */
    #[ArrayShape([
        'id' => "mixed",
        'case_id' => "mixed",
        'case_name' => "string",
        'insurer_id' => "mixed",
        'insurer_company_name' => "string",
        'description' => "mixed"]
    )]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'case_id' => $this->case_id,
            'case_name' => $this->caseName(),
            'insurer_id' => $this->insurer_id,
            'insurer_company_name' => $this->companyName(),
            'description' => $this->description,
        ];
    }

    /**
     * @var string[] $fillable fields to be mass-assigned.
     */
    protected $fillable = ['case_id', 'description'];
}
