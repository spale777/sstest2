<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/16/2016
 * Time: 5:46 PM
 */
class PropertySearchPage extends Page
{

}
class PropertySearchPage_Controller extends Page_Controller
{
    public function index(SS_HTTPRequest $request)
    {
        $properties = Property::get();
        $filters = ArrayList::create();

        if($search = $request->getVar('Keywords')) {
            $filters->push(ArrayData::create([
                'Label' => "Keywords: '$search'",
                'RemoveLink' => HTTP::setGetVar('Keywords', null)
            ]));
            $properties = $properties->filter([
                'Title:PartialMatch' => $search
            ]);
        }

        if($arrival = $request->getVar('ArrivalDate')) {
            $arrivalStamp = strtotime($arrival);
            $nightAdder = '+'.$request->getVar('Nights').' days';
            $startDate = date('Y-m-d', $arrivalStamp);
            $endDate = date('Y-m-d', strtotime($nightAdder, $arrivalStamp));

            $properties = $properties->filter([
                'AvailableStart:LessThenOrEqual' => $startDate,
                'AvailableEnd:GreaterThenOrEqual' => $endDate
            ]);
        }

        if($bedrooms = $request->getVar('Bedrooms')){
            $filters->push(ArrayData::create([
                'Label' => "$bedrooms bedrooms",
                'RemoveLink' => HTTP::setGetVar('Bedrooms', null)
            ]));
            $properties = $properties->filter([
                'Bedrooms:GreaterThenOrEqual' => $bedrooms
            ]);
        }

        if($bathrooms = $request->getVar('Bathrooms')){
            $filters->push(ArrayData::create([
                'Label' => "$bathrooms bathrooms",
                'RemoveLink' => HTTP::setGetVar('Bathrooms', null)
            ]));
            $properties = $properties->filter([
                'Bathrooms:GreaterThenOrEqual' => $bathrooms
            ]);
        }

        if($minPrice = $request->getVar('MinPrice')){
            $filters->push(ArrayData::create([
                'Label' => "Min \$$minPrice",
                'RemoveLink' => HTTP::setGetVar('MinPrice', null)
            ]));
            $properties = $properties->filter([
                'PricePerNight:GreaterThanOrEqual' => $minPrice
            ]);
        }

        if($maxPrice = $request->getVar('MaxPrice')){
            $filters->push(ArrayData::create([
                'Label' => "Max \$$maxPrice",
                'RemoveLink' => HTTP::setGetVar('MaxPrice', null)
            ]));
            $properties = $properties->filter([
                'PricePerNight:LessThanOrEqual' => $maxPrice
            ]);
        }

        $paginatedProperties = PaginatedList::create($properties, $request)
            ->setPageLength(15)
            ->setPaginationGetVar('s');

        $data = [
            'Results' => $paginatedProperties,
            'ActiveFilters' => $filters
        ];

        if($request->isAjax()){
            return $this->customise($data)
                        ->renderWith('PropertySearchResults');
        }

        return $data;
    }

    public function PropertySearchForm()
    {
        $nights = [];
        foreach(range(1,14) as $i){
            $nights[$i] = "$i night" . (($i > 1) ? 's' : '');
        }

        $prices = [];
        foreach(range(100,1000,50) as $i){
            $prices[$i] = '$'.$i;
        }

        $form = Form::create(
            $this,
            'PropertySearchForm',
            FieldList::create(
                TextField::create('Keywords')
                    ->setAttribute('placeholder', 'City, State, Country, etc . . .')
                    ->addExtraClass('form-control'),
                TextField::create('ArivalDate', 'Arrive on...')
                    ->setAttribute('data-datepicker', true)
                    ->setAttribute('data-date-format', 'DD-MM-YYYY')
                    ->addExtraClass('form-control'),
                DropdownField::create('Nights', 'Stay for...')
                    ->setSource($nights)
                    ->addExtraClass('form-control'),
                DropdownField::create('MinPrice', 'Min. Price')
                    ->setEmptyString('-- Any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control'),
                DropdownField::create('MaxPrice','Max. price')
                    ->setEmptyString('-- Any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control')
            ),
            FieldList::create(
                FormAction::create('doPropertySearch', 'Search')
                    ->addExtraClass('btn-lg btn-fullcolor')
            )
        );

        $form->setFormMethod('Get')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());

        return $form;
    }
}