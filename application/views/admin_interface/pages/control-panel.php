<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<hr/>
			<?php $this->load->view("admin_interface/includes/rightbar");?>
			<div class="span9">

				<ul class="thumbnails">
	              <li class="span3">
	                <div class="thumbnail">
	                	<?=anchor(ADM_START_PAGE.'/pages','<img data-src="holder.js/260x180" alt="260x180" style="width: 260px; height: 180px; " src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQQAAAC0CAYAAABytVLLAAAIhUlEQVR4Xu3avYsUWxMH4N7AL9DARM1EDNVQBP99IxMxUoxFMJBFEBHBj/ftgbO07cxsrXW99K16TMT1TM2pp7p/0907J6enpz8nfwgQIPB/gROB4DggQGAICATHAgECZwICwcFAgIBAcAwQIPC7gCsERwUBAq4QHAMECLhCcAwQIHBEwC2Dw4MAAbcMjgECBNwyOAYIEHDL4BggQCAi4BlCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgbHDQr1+/nt69e3e2sxs3bkxPnjz5Zaenp6fTy5cvpx8/fux+vm/N27dvpzdv3py97t69e9P9+/f/uOMXL15M8/vevn17evTo0S91xv+NH+5b80/v548b8cKDAgJhYwfH+sQa21ue8Osw2HcSrk++seZPQ2FZb32yrwPs39jPxsZWZjsCYUOj/Pbt2/Ts2bPp+/fv0zhxlyfiw4cPp1u3bk3Pnz+fPn/+/Nuak5OT6enTp9OVK1fO1oyTd5y0V69e3V1tXLp0Kdz5sU//5Z7X7/W39hPeuIUXFhAIFyb7ey8YJ/84ka5duzatQ+Lu3bu70JhvFeaTf16z/rO8gphD5M6dO7tL/fkW4+fPn7vXffny5eyWY4TP+nXL8JnfYw6ar1+//nLLsNxf5L0OrdnXx9+TVvmQgEDY+LGxPkkvX768O5Hnv+dP+48fP+46WF7Gr0/+dbCMk3J88s91Hj9+PM3/nq88Rq05dOarkevXr08PHjz47apjft+xZvm69dXIp0+ffgmjQ/vZ+ChabE8gbHjMy5NtPEM49GxgbmO95tiVxvxwcfnpPl9FvH//flq+Zkmz78Qf/7+sM362rBO58sk87NzwCP9zWxMIGx3Z8gTcd3LN214/ZxjrPnz4sPvtwnmBMNeIPvk/FgjnPcAUCBs9yPZsSyBscFaHwmDeauR2YNxWjOcFxy7Rl5/uh64ODt0azD8/9iB01BvPKyL72eA4Wm1JIGxs3MfC4KKBMNc67yHe+leG+74/cCwQIp/+N2/ePHuAed5+NjaOdtsRCBsb+XjQd5F7+fVJGf214/JqY35o+OrVq91DwnHSRp4hLB96Rn5V+k/8GnRjIyu1HYGwoXEe+sLR2OK+E265/eWn+3n39ZHfDiy/q3DoGcLy52vK5ZepztvPhsbQeisCYUPjP/SNv3UgLG8dxleXL/pV4fFehx48rusde6g472f95aV/46vUGxpdma0IhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvMD/ANbXEGO2tfHZAAAAAElFTkSuQmCC">');?>
		                <div class="caption">
	                    	<p><strong>Content management</strong></p>
	                    </div>
	                </div>
	              </li>
	              <li class="span3">
	                <div class="thumbnail">
	                  	<?=anchor('administrator/broker/accounts','<img data-src="holder.js/260x180" alt="260x180" style="width: 260px; height: 180px; " src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQQAAAC0CAYAAABytVLLAAAIhUlEQVR4Xu3avYsUWxMH4N7AL9DARM1EDNVQBP99IxMxUoxFMJBFEBHBj/ftgbO07cxsrXW99K16TMT1TM2pp7p/0907J6enpz8nfwgQIPB/gROB4DggQGAICATHAgECZwICwcFAgIBAcAwQIPC7gCsERwUBAq4QHAMECLhCcAwQIHBEwC2Dw4MAAbcMjgECBNwyOAYIEHDL4BggQCAi4BlCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgNBm0NglEBARCRMkaAk0EBEKTQWuTQERAIESUrCHQREAgbHDQr1+/nt69e3e2sxs3bkxPnjz5Zaenp6fTy5cvpx8/fux+vm/N27dvpzdv3py97t69e9P9+/f/uOMXL15M8/vevn17evTo0S91xv+NH+5b80/v548b8cKDAgJhYwfH+sQa21ue8Osw2HcSrk++seZPQ2FZb32yrwPs39jPxsZWZjsCYUOj/Pbt2/Ts2bPp+/fv0zhxlyfiw4cPp1u3bk3Pnz+fPn/+/Nuak5OT6enTp9OVK1fO1oyTd5y0V69e3V1tXLp0Kdz5sU//5Z7X7/W39hPeuIUXFhAIFyb7ey8YJ/84ka5duzatQ+Lu3bu70JhvFeaTf16z/rO8gphD5M6dO7tL/fkW4+fPn7vXffny5eyWY4TP+nXL8JnfYw6ar1+//nLLsNxf5L0OrdnXx9+TVvmQgEDY+LGxPkkvX768O5Hnv+dP+48fP+46WF7Gr0/+dbCMk3J88s91Hj9+PM3/nq88Rq05dOarkevXr08PHjz47apjft+xZvm69dXIp0+ffgmjQ/vZ+ChabE8gbHjMy5NtPEM49GxgbmO95tiVxvxwcfnpPl9FvH//flq+Zkmz78Qf/7+sM362rBO58sk87NzwCP9zWxMIGx3Z8gTcd3LN214/ZxjrPnz4sPvtwnmBMNeIPvk/FgjnPcAUCBs9yPZsSyBscFaHwmDeauR2YNxWjOcFxy7Rl5/uh64ODt0azD8/9iB01BvPKyL72eA4Wm1JIGxs3MfC4KKBMNc67yHe+leG+74/cCwQIp/+N2/ePHuAed5+NjaOdtsRCBsb+XjQd5F7+fVJGf214/JqY35o+OrVq91DwnHSRp4hLB96Rn5V+k/8GnRjIyu1HYGwoXEe+sLR2OK+E265/eWn+3n39ZHfDiy/q3DoGcLy52vK5ZepztvPhsbQeisCYUPjP/SNv3UgLG8dxleXL/pV4fFehx48rusde6g472f95aV/46vUGxpdma0IhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvIBAyBuqQKCMgEAoM0qNEMgLCIS8oQoEyggIhDKj1AiBvMD/ANbXEGO2tfHZAAAAAElFTkSuQmCC">');?>
		                <div class="caption">
	                    	<p><strong>Accounts management</strong></p>
	                    </div>
	                </div>
	              </li>
	            </ul>

			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
