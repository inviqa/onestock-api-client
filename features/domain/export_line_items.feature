Feature: Exporting line item updates
    In order to keep previously exported order up to date
    As a warehouse administrator
    I should be able to send line item changes to OneStock

    Scenario: Successfully exporting line items
        When I send the following line item update:
            """
            [
                {
                    "id": "1234",
                    "payment": {
                        "price": "99.99",
                        "previous_price": "10.99",
                        "discount_absolute": "19.99",
                        "discount_percentage": "20"
                    },
                    "information": {
                        "foo": "bar"
                    },
                    "delivery": {
                        "tracking_code": "tracking001",
                        "carrier": {
                            "name": "AMCE shipping",
                            "option": "CODE_ACME"
                        }
                    },
                    "from": "created",
                    "to": "removed"
                }
            ]
            """
        Then the API should return a successful response
