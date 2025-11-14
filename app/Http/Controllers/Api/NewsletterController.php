<?php

use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class NewsletterController extends Controller
{
    public function __construct(protected NewsletterService $service) {}

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_emails,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'E-mail inválido ou já cadastrado.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->service->subscribe($request->email);
            return response()->json(['message' => 'E-mail cadastrado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro interno ao salvar e-mail.'], 500);
        }
    }
}