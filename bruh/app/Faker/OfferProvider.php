<?php

namespace App\Faker;

use App\Models\Offer;
use Faker\Provider\Base;

class OfferProvider extends Base
{
    /**
     * TODO: is rand in PHP secure ? who cares..--> might try using PHP Faker internal methods.
     */

    /**
     * TODO: Data is duplicated here and in @App\Models\Offer
     *
     * @var array|string[] all possible offer descriptions by case
     */
    protected static array $descriptionValues = [
        'vehicle' => [
            /* Bicycle */
            'Your bike is worth to us what it’s worth to you. We do not depreciate your bike so in case of a total loss you can get yourself a bike of similar value.',
            'Your bike is covered if it’s damaged in a crash. On a road or trail, a group ride or a race, if it’s damaged in an accident, it’s covered.',
            'If your bike is stolen from your home, car, workplace or any other secure location, it’s covered.',
            'Our cycling insurance policy is superior to any other similar product available in the insurance marketplace. There simply is no substitute.',
            'We are proud to serve our fellow cyclists with an insurance policy that covers just about anything that can happen to a bike.',
            /* Car */
            'Fully comprehensive car insurance is the highest level of cover you can get. You’ll be protected against damage, repairs, medical expenses, fire damage, and theft. As well as damage to someone else, their car or property.',
            'Third-party, fire and theft policies offer cover for other people, their vehicles, and their property, as well as protection for your own car if it were to get stolen, or if it’s damaged by fire.',
            'Third-party only car insurance is the minimum legal requirement you need, and it’s also usually the most expensive type of cover. It covers injuries to other people, and damage to their vehicles and property.',
        ],
        'health' => [
            'Plans that offer coverage from birth to adulthood.',
            'Temporary health plans that fit almost any lifestyle or budget.',
            'Plans for people 65 or older or those who may qualify because of a disability or special condition.',
            'Coverage to add on to health insurance plans.',
            'Your employees are your greatest investment. And health insurance is a critical factor in retaining and recruiting employees, as well as maintaining productivity and satisfaction.',
            'Choosing effective, sustainable health insurance coverage for your business helps build a solid foundation for balancing costs and prioritizing care for your employees.',
            'For a small business, health insurance is a critical factor in retaining and recruiting employees, as well as maintaining productivity and employee satisfaction.',
        ],
        'income protection' => [
            'Many of us would struggle to keep on top of our essential outgoings, such as mortgage and rent, if we lost an income due to illness or an accident. Income protection is a long-term insurance policy that makes sure you get a regular income until you retire or are able to return to work.',
            'Needing to arrange care for yourself or a loved one is more common than ever and the first steps are stressful.',
            'Our divorce and separation section is here to give you all the guidance you need when it comes to managing your finances during a relationship break-up.',
        ],
        'casualty' => [
            'Casualty insurance is a broad category of insurance coverage for individuals, employers, and businesses against loss of property, damage, or other liabilities.',
            'If you own a business, you should consider a few different types of casualty insurance, depending on what you do. One essential type of casualty insurance for businesses is workers compensation insurance, which protects a company from liabilities that arise when a worker is injured on the job.',
            'Casualty insurance includes vehicle insurance, liability insurance, and theft insurance. Liability losses are losses that occur as a result of the insured’s interactions with others or their property.',
            'Just as you can purchase property insurance to protect yourself from financial loss, liability insurance protects you from financial loss if you become legally liable for injury to another or damage to property.',
        ],
        'life' => [
            'Life insurance is a contract between an insurer and a policy owner. A life insurance policy guarantees the insurer pays a sum of money to named beneficiaries when the insured dies in exchange for the premiums paid by the policyholder during their lifetime.',
            'Tell us a little about yourself to find out how much life insurance coverage you may need.',
            'Life has so much to offer. To ensure that you live yours to the fullest, our life protection insurance provides comprehensive solutions to grow your wealth and to protect your health according to your changing needs and goals.',
        ],
        'property' => [
            'Property insurance provides financial reimbursement to the owner or renter of a structure and its contents in case there is damage or theft—and to a person other than the owner or renter if that person is injured on the property.',
            'Property insurance can include a number of policies, such as homeowners insurance, renters insurance, flood insurance, and earthquake insurance.',
            'Personal property is usually covered by a homeowners or renters policy. The exception is personal property that is very high value and expensive—this is usually covered by purchasing an addition to the policy called a "rider." If there\'s a claim, the property insurance policy will either reimburse the policyholder for the actual value of the damage or the replacement cost to fix the problem.'
        ],
        'credit' => [
            'Trade credit insurance provides cover for businesses if customers who owe money for products or services do not pay their debts, or pay them later than the payment terms dictate. It gives businesses the confidence to extend credit to new customers and improves access to funding, often at more competitive rates.',
            'Credit insurance providers offer flexible products to meet the needs of individual businesses.',
            'Transferring risk away from the business and over to an insurer, credit insurance protects the policyholder in the event of a customer becoming insolvent or failing to pay its trade credit debts. Not only this, but insurers can actually help to reduce the risk of financial loss through credit management support.',
        ],
    ];

    public function issueCase(): int
    {
        return array_rand(Offer::CASES, 1);
    }

    public function issueDescription(int $issueCaseId = 0): string
    {
        if ($issueCaseId == 0) {
            $issueCaseId = $this->issueCase();
        }

        $caseName = Offer::getCaseNameById($issueCaseId);

        return self::$descriptionValues[$caseName][array_rand(self::$descriptionValues[$caseName], 1)];
    }
}
