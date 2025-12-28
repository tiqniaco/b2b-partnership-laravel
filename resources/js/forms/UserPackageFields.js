export const fields = [
  { key: "user_id", label: "User Id", required: 1, placeholder: "Enter User Id", type: "number", isString: false },
  { key: "package_id", label: "Package Id", required: 1, placeholder: "Enter Package Id", type: "number", isString: false },
  { key: "start_date", label: "Start Date", required: 1, placeholder: "Enter Start Date", type: "text", isString: false },
  { key: "end_date", label: "End Date", required: 1, placeholder: "Enter End Date", type: "text", isString: false },
  { key: "status", label: "Status", required: 1, placeholder: "Enter Status", type: "select", isString: false,
      options: [
    {
        "value": "active",
        "label": "Active"
    },
    {
        "value": "expired",
        "label": "Expired"
    },
    {
        "value": "canceled",
        "label": "Canceled"
    },
    {
        "value": "pending",
        "label": "Pending"
    }
] },
  { key: "price", label: "Price", required: 1, placeholder: "Enter Price", type: "number", isString: false },
  { key: "transaction_id", label: "Transaction Id", required: 1, placeholder: "Enter Transaction Id", type: "text", isString: false },
  { key: "payment_method", label: "Payment Method", required: 1, placeholder: "Enter Payment Method", type: "select", isString: false,
      options: [
    {
        "value": "credit_card",
        "label": "Credit_card"
    },
    {
        "value": "paypal",
        "label": "Paypal"
    },
    {
        "value": "bank_transfer",
        "label": "Bank_transfer"
    }
] },
  { key: "is_trial", label: "Is Trial", required: 1, placeholder: "Enter Is Trial", type: "boolean", isString: false }
];