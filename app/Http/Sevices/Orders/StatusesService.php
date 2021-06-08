<?php


namespace App\Http\Sevices\Orders;




use App\Http\Sevices\Service;
use App\Models\OrderStatus;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class StatusesService extends OrderService
{

    public function GetStatuses(): Collection
    {
        $statuses = new OrderStatus();
        $statusesWithOrderNum = Collect();
        foreach ($statuses->get() as $status)
        {
            $status->SetNumberOfOrders($this->OrdersOfStatus($status));
            $statusesWithOrderNum->push($status);
        }
        return $statusesWithOrderNum;
    }

    /**
     * @throws ValidationException
     */
    public function SaveNewStatus($data)
    {
        $dataArray = ['status' => $data['status'], 'color' => $data['color']];
        $params = [$this->textRus, $this->textRusEng];
        $validatedStatus = $this->ValidateInput($dataArray, $params)->validated();
        return OrderStatus::firstOrCreate($validatedStatus);
    }

    /**
     * @throws ValidationException
     */
    public function EditStatus($data)
    {
        $dataArray = ['status' => $data['status'], 'color' => $data['color']];
        $params = [$this->textRus, $this->textRusEng];
        $validatedParams = $this->ValidateInput($dataArray, $params)->validated();
        return OrderStatus::find($data['id'])->update($validatedParams);
    }
}