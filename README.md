
Talaf Smart Tester System

Developers
	•	Alhanouf Hamid Alotaibi (442013621)
	•	Raghad Mohammed Almutairi (442013221)
	•	Milaf Saleh Alaqil (442012219)

Supervised by: Ghadah Alshabana

Introduction

 Talaf is a smart tester system designed to improve hygiene in physical stores by offering contactless testing of liquid products, such as perfumes and cosmetics. It integrates hardware and software to dispense products automatically when a customer’s hand is detected and provides detailed product information through barcode scanning. Additionally, a survey collects customer feedback to analyze preferences, enhancing inventory management and customer satisfaction.
Software and Hardware Used

Hardware:

* Sensors: Devices that sense when the customer's hand is close and start the liquid dispensing process without any touch.

* Container: A box or bottle that holds the liquid product (like creams or perfumes).

* Relay:An electronic switch that turns the pump or other parts on and off when it gets a signal from the Arduino.

* Silicone Tube:A soft and flexible tube made of silicone that moves the liquid from the container to the customer.

* Arduino:A small computer that runs the program and controls the sensors, relay, and pump.

* Breadboard:A board used for building and testing circuits without soldering. It allows easy connections between parts.

* Water Pump:A device that pushes the liquid (like water or other liquids) from the container to the outlet.

* Wires: Thin cables used to connect the parts of the circuit and let electricity flow between them.

* Power Supply: A device that gives the needed energy (like 5V) to run all the parts in the circuit.

* Resistors:Small electronic parts that control and reduce the flow of electricity to protect the circuit.

Software:

User Side:
	•	Barcode Scanning: Provides product details and a survey for feedback.
	•	Customer Feedback Analysis: Analyzes preferences based on survey data.

Employee Side:
	•	Smart Tester Management: Add, modify, or delete Smart Testers.
	•	Barcode Generation: Generate and link barcodes to Smart Testers.
	•	Sign In/Log In: Secure access for employees.
	•	Log Out: Safely exit the system.

Installation Instructions

Prerequisites:
	1.	Hardware Setup:
	•	Install sensor-based Smart Tester devices at store locations.
	•	Attach barcode stickers to each tester.
	2.	Software Requirements:
	•	A compatible web server for hosting the system.
	•	A database management system (e.g., SQLite).
           •	A camera to scan the barcode.
 
	
	

Troubleshooting

Common Issues:
	1.	Sensor Not Detecting Hand:
	•	Ensure the sensor is clean and correctly aligned.
	•	Verify power connections to the Smart Tester.
	2.	Barcode Scan Fails:
	•	Check the barcode for damage or errors.
	•	Confirm that the barcode is linked to product information in the database.
	3.	System Not Displaying Surveys:
	•	Ensure the web server is operational and connected to the database.

Contact Information

For support, bug reports, or feedback, please contact:
Email: talafi507@gmail.com


