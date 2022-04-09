AFTER UPDATE ON `@@@pay` FOR EACH ROW
IF (NEW.`sum`<>OLD.`sum` OR NEW.`payd` <> OLD.`payd`) THEN
    DELETE FROM @@@invoicepay WHERE idpay = OLD.id;
    CALL @@@sportsmen_calc_saldo(NEW.`sportsmen`);
    CALL @@@invoicepay_recalc(NEW.`sportsmen`);
END IF
