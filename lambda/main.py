import json
import base64
import os
import boto3
from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse
from fastapi.encoders import jsonable_encoder
from mangum import Mangum



AWS_REGION = os.getenv('AWS_REGION')

def cors_headers():
	return { 'Access-Control-Allow-Methods': 'POST, GET, OPTIONS', 'Access-Control-Allow-Headers': 'Content-Type, Authorization' }
def _response(status_code=200, data=None):
	return JSONResponse( status_code=status_code, headers=cors_headers(), content=jsonable_encoder(data) )
def _401(err=None):
	return JSONResponse( status_code=401, headers=cors_headers(), content={'error': err or 'Unauthorized'} )
def _422(err=None):
	return JSONResponse( status_code=422, headers=cors_headers(), content={'error': err or 'Missing field in request'} )
def _500(err=None):
	return JSONResponse( status_code=500, headers=cors_headers(), content={'error': err or 'Internal server error'} )



app = FastAPI()
ses_client = boto3.client('ses', region_name=AWS_REGION)



# CORS preflight
@app.options('/{path:path}')
def cors_preflight(request: Request, path: str):
	return JSONResponse(
		content={'message': 'CORS preflight success'},
		headers=cors_headers()
	)



@app.post("/new_lead")
async def new_lead(request: Request):
	event = await request.json()
	if not 'email' in event and not 'message' in event: return _422()

	op = 'nfedb'
	if 'op' in event: op = event['op']

	RES = {}
	STATUS_CODE = 0

	try:
		response = ses_client.send_email(
			Source='contact@geotales.io',
			Destination={ 'ToAddresses': [ 'aca@geotales.io', 'jeh@geotales.io' ] },
			Message={
				'Subject': { 'Data': f'Ny melding, {op} kontaktskjema' },
				'Body': {
					'Text': {
						'Data': f'''Fra {event["email"]}, {event["message"]}'''
					}
				}
			}
		)
		RES = {'status': 'success'}
		STATUS_CODE = 200

	except Exception as e:
		print(f'Error: {e}')
		RES = {'error': 'Internal Server Error'}
		STATUS_CODE = 500

	finally:
		return _response(STATUS_CODE, RES)



handler = Mangum(app)
