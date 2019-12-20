Feature: Exporting line item updates
    In order to keep previously exported order up to date
    As a warehouse administrator
    I should be able to send line item changes to OneStock

    Scenario: Successfully exporting line items
        Given the following line items is changed:
            """
            {
                "item_id": "1234",
                "payment": {
                    "price": "99.99",
                    "previous_price": "10.99"
                }
            }
            """
        When line items updates are exported
        Then it should be successful
