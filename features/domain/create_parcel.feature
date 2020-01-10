Feature: Create Parcel

    Scenario: Export a parcel
        When I create the following parcel:
            """
            {
                "id": "1234",
                "date": 201901090000,
                "to": "shipped",
                "order_id": 1234,
                "line_item_ids": [ 1, 2, 3 ,4 ],
                "tracking_code": "1234"
            } 
            """
        Then the API should return a successful response
        And the following request should be sent to Onestock:
        """
        {
            "site_id": "s100",
            "parcel": {
                "id": "1234",
                "date": 201901090000,
                "to": "shipped",
                "order_id": "1234",
                "line_item_ids": [
                    1,
                    2,
                    3,
                    4
                ],
                "tracking_code": "1234"
            }
        }
        """
