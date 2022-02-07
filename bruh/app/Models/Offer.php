<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public static function getCaseId(string $case): int
    {
        return array_search($case, self::CASES);
    }

    /**
     * Get case name by provided case id.
     *
     * @param int $caseId case id
     * @return string case name/value
     */
    public static function getCaseNameById(int $caseId): string
    {
        return self::CASES[$caseId];
    }

    /**
     * Get case name by case id.
     *
     * @return string case name/value
     */
    public function getCaseName(): string
    {
        return self::CASES[$this->attributes['case_id']];
    }

    /**
     * Get offer's insurer.
     *
     * @return BelongsTo insurer
     */
    public function getInsurer(): BelongsTo
    {
        return $this->belongsTo(Insurer::class, 'insurer_id', 'id');
    }

    /**
     * Get company name that published this offer.
     * TODO: Might slow down stuff
     *
     * @return string company name
     */
    public function getCompanyName(): string
    {
        return $this->getInsurer()->get()->first()->company_name;
    }

    /**
     * Convert model to an array.
     * Necessary for elasticsearch match.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'case_id' => $this->case_id,
            'case' => $this->getCaseName(),
            'insurer_id' => $this->insurer_id,
            'insurer' => $this->getCompanyName(),
            'description' => $this->description,
        ];
    }

    /**
     * @var string[] $fillable fields to be mass-assigned.
     */
    protected $fillable = ['case_id', 'description'];
}
