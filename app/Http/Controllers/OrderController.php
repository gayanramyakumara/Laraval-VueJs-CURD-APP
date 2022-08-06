<?php
/**
 * @author Gayan R. <gayanramyakumara@gmail.com>
 * @date 2022-08-05 19:46:27
 * 
 * This controller manage all activity of the order
 */

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Utils\RespondsWithHttpStatus;
use App\Services\EmailService;
use App\Services\RevolutOrderService;
use App\Utils;
use Exception;
use App\Repository\OrderRepository;

class OrderController extends Controller
{
    use RespondsWithHttpStatus;

    public $revolutOrderService;
    public $emailService;

    public function __construct(RevolutOrderService $revolutOrderService, EmailService $emailService)
    {
        $this->revolutOrderService  = $revolutOrderService;
        $this->emailService         = $emailService;
    }

    /**
     * @return string[]
     */
    private function rules()
    {
        return [
            'amount'    => 'required|numeric',
            'email'     => 'required|email|max:100',
            'currency'  => 'required',
        ];
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::paginate( Utils::PAGINATION_LIMIT);
        return response()->json($data);
    }

    /**
     * This method manage order creation related all services
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OrderRepository $orderRepository)
    {

        try {

            $data = $request->only([
                'amount', 'email', 'currency'
            ]);

            $validator = Validator::make($data, $this->rules());

            if ($validator->fails()) {
                return $this->respondWithError($validator->errors(), Utils::ERROR_CODE_UNPROCESSABLE);
            }
 
            //Create Order for Revolut
            $orderRes = $this->revolutOrderService->create($request->post());

            if ($orderRes->status === false) {

                return response()->json(['errors' => Utils::COMMON_ERROR_MESSAGE, 'type' => Utils::ERROR_TYPE_COM, 'exception' => $orderRes->error], Utils::ERROR_CODE_UNPROCESSABLE);
            }

            # DATABASE SAVING
            $dataArr = [
                'email'     => $request->post('email'),
                'amount'    => $request->post('amount'),
                'currency'  => $request->post('currency'),
                'status'     => !empty($orderRes->data['state']) ? $orderRes->data['state'] : null,
                'customer_id' => !empty($orderRes->data['customer_id']) ? $orderRes->data['customer_id'] : null,
            ];

            // Persist user to database
            $orderData = $orderRepository->create($dataArr);
            if($orderData){
                # SEND EMAIL        
                $sendEmail = $this->emailService->send($dataArr);

            }
            
            return $this->respond($orderData, Utils::ERROR_CODE_SUCCESS);
        } catch (Exception $e) {
            return response()->json(['errors' => Utils::COMMON_ERROR_MESSAGE, 'type' => Utils::ERROR_TYPE_COM, 'exception' =>$e->getMessage() , 'error_line' => $e->getLine()],  Utils::ERROR_CODE_UNPROCESSABLE);
        }
    }
}
