<?php
/**
 * Created by PhpStorm.
 * User: Harris
 * Date: 05/11/2017
 * Time: 05:29 AM
 */


namespace App\Services;


use App\Repositories\VoucherRepository;
use Illuminate\Http\Request;
use App\Http\Requests\VoucherRequest;

class VoucherService
{
    protected $repository;
    protected $departmentService;

    public function __construct(VoucherRepository $voucherRepository, DepartmentService $departmentService)
    {
        $this->repository = $voucherRepository;
        $this->departmentService = $departmentService;
    }

    public function getAll(int $n = null, array $fields = null)
    {
        $vouchers = $this->repository->getAll($n, $fields);
        return $vouchers
            ? $vouchers
            : response()->json(['message' => 'the resource you requested was not found']);
    }

    public function getById($id)
    {
        $voucher = $this->repository->getById($id);
        return $voucher
            ? $voucher
            : response()->json(['message' => 'the resource you requested was not found']);
    }


    public function create(VoucherRequest $request)
    {
        if (!$this->repository->create($request->getAttributesArray())) {
            return response()->json(['message' => 'the resource was not created', 'data' => $request->getAttributesArray()], 500);
        }
        return response()->json(['message' => 'the resource was successfully created', 'data' => $request->getAttributesArray()], 200);
    }

    public function update($id, VoucherRequest $request)
    {
        if (!$this->repository->update($id, $request->getAttributesArray())) {
            return response()->json(['message' => 'the resource was not updated', 'data' => $request->getAttributesArray()], 500);
        }
        return response()->json(['message' => 'the resource was successfully updated', 'data' => $request->getAttributesArray()], 200);
    }

    public function delete($id)
    {
        if (!$this->repository->delete($id)) {
            return response()->json(['message' => 'the resource was not deleted']);
        }
        return response()->json(['message' => 'the resource was successfully deleted']);
    }


    public function approveVoucher($voucherId)
    {
        $voucher = [
            'status' => 'Accepted'
        ];
        if (!$this->repository->update($voucherId, $voucher)) {
            return response()->json(['message' => 'the resource was not updated', 'data' => $voucher], 500);
        }
        return response()->json(['message' => 'the resource was successfully updated', 'data' => $voucher], 200);
    }

    public function hasPaidVoucher($voucherId)
    {
        $voucher = [
            'paid' => true
        ];
        if (!$this->repository->update($voucherId, $voucher)) {
            return response()->json(['message' => 'the resource was not updated', 'data' => $voucher], 500);
        }
        return response()->json(['message' => 'the resource was successfully updated', 'data' => $voucher], 200);
    }

    public function getPayableVouchers()
    {
        $vouchers = $this->repository->getByParam('status', 'Accepted');
        return $vouchers
            ? $vouchers
            : response()->json(['message' => 'there are currently no payable vouchers']);
    }

    public function getUserVouchers($userId)
    {
        $usersVouchers = $this->repository->getByParam('user_id', $userId);
        return $usersVouchers
            ? $usersVouchers
            : response()->json(['message' => 'the resource you requested was not found']);
    }

    public function getOfficeEntityVouchers($officeEntityId)
    {
        $officeEntityVouchers = $this->repository->getByParam('office_entity_id',$officeEntityId);
        return $officeEntityVouchers
            ? $officeEntityVouchers
            : response()->json(['message' => 'the resource you requested was not found']);
    }




}